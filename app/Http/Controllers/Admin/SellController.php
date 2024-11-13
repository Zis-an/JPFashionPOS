<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateAccountBalanceJob;
use App\Jobs\UpdateProductSellPricesJob;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\Sell;
use App\Models\SellStock;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellController extends Controller
{
    public function index(): View|Factory|Application
    {
        UpdateProductSellPricesJob::dispatch();
        $sells = Sell::orderBy('id', 'DESC')->get();
        return view('admin.sells.index', compact('sells'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $sells = Sell::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.sells.trashed', compact('sells'));
    }

    public function create(): View|Factory|Application
    {
        $stockProducts = ProductStock::with('product', 'showroom')->get();
        $productCategories = ProductCategory::all();
        $currencies = Currency::all();
        $salesman = Admin::where('type', '=', 'salesman')->get();
        $customers = Customer::all();
        $accounts = Account::all();
        return view('admin.sells.create',
            compact('stockProducts', 'productCategories', 'currencies', 'salesman', 'customers', 'accounts'));
    }

    public function setCurrency(Request $request): RedirectResponse
    {
        $request->validate([
            'currency_id' => 'required|exists:currencies,id',
        ]);

        // Fetch the selected currency from the database
        $selectedCurrency = Currency::find($request->currency_id);

        // Store the selected currency in the session
        session(['currency' => $selectedCurrency]);

        // Redirect back to the create page
        return redirect()->route('admin.sells.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $currency_id = session('currency')['id'];
        $selectedCurrency = Currency::find($currency_id);
        if (!$selectedCurrency) {
            return redirect()->route('admin.sells.create')->with('error','Currency not found');
        }
        // Validate the request
        $request->validate([
            'customer' => 'required',
            'salesman' => 'required',
            'account_id' => 'required',
            'stock_id' => 'required|array',
            'stock_id.*' => 'exists:product_stocks,id',
            'product_price' => 'required|array',
            'product_quantity' => 'required|array',
            'discount_type' => 'required|array',
            'discount_amount' => 'required|array',
            'product_total' => 'required|array',
        ]);

        // Calculate totals
        $totalAmount = array_sum($request->product_total); // Sum of individual product totals
        $discountAmount = array_sum($request->discount_amount); // Sum of discounts applied
        $netTotal = $totalAmount - $discountAmount; // Net total after discount

        // Determine the paid amount based on the request
        $paidAmount = 0; // Default value


        // Create the sell record
        $sell = Sell::create([
            'customer_id' => $request->customer,
            'salesman_id' => $request->salesman,
            'account_id' => $request->account_id,
            'currency_id'=>$currency_id,
            'total_amount' => $totalAmount,
            'discount_amount' => $discountAmount,
            'net_total' => $netTotal,
            'paid_amount' => $paidAmount,
        ]);

        foreach ($request->stock_id as $key => $stockId) {
            // Retrieve the product stock only once
            $productStock = ProductStock::find($stockId);
            // Calculate the initial total without discount
            $initialTotal = $request->product_price[$key] * $request->product_quantity[$key];

            // Apply discount based on type
            if ($request->discount_type[$key] == 'percentage') {
                $discountAmount = $initialTotal * ($request->discount_amount[$key] / 100);
            } else { // 'fixed' discount type
                $discountAmount = $request->discount_amount[$key]??0;
            }

            // Calculate final total after discount
            $finalTotal = $initialTotal - $discountAmount;

            // Insert into the sell_stocks table
            DB::table('sell_stocks')->insert([
                'sell_id' => $sell->id,
                'stock_id' => $stockId,
                'currency_id'=>$currency_id,
                'cost' => $productStock->total_cost_price * $request->product_quantity[$key],
                'price' => $request->product_price[$key],
                'quantity' => $request->product_quantity[$key],
                'discount_type' => $request->discount_type[$key],
                'discount_amount' => $discountAmount,
                'total' => $finalTotal
            ]);

            // Update the quantity in the ProductStock table
            $productStock->decrement('quantity', $request->product_quantity[$key]);
        }
        // Retrieve all required sums in a single query
        $sellStockSums = SellStock::where('sell_id', $sell->id)
            ->selectRaw('SUM(price * quantity) as total_price')
            ->selectRaw('SUM(discount_amount) as total_discount')
            ->selectRaw('SUM(total) as net_total')
            ->first();

        if ($request->paidAmountOption == 'paid_in_full') {
            $paidAmount = $sellStockSums->net_total; // Set to net total when paid in full
        } elseif ($request->paidAmountOption == 'custom_amount') { // Update this line
            $paidAmount = $request->amount; // Use the correct input name
        }

        // Update the Sell record with calculated values
        $sell->update([
            'total_amount' => $sellStockSums->total_price,
            'discount_amount' => $sellStockSums->total_discount,
            'net_total' => $sellStockSums->net_total,
            'paid_amount'=> $paidAmount
        ]);
        $sell = Sell::findOrFail($sell->id);
        $convertedData = getDefaultCurrencyConvertedPrice($sell);
        $reference = sprintf(
            '%s sale has been created with a status of "%s" for %s (Customer) by %s (Salesman) with reference ID: %s.',
            class_basename($sell),        // Model's class name without the namespace
            $sell->status,                // Current status of the sale (e.g., "approved")
            $sell->customer->name,        // Customer's name associated with the sale
            $sell->salesman->name,        // Salesman's name associated with the sale
            $sell->unique_sale_id         // Unique sale ID with "INV" prefix
        );
        // Get 'I' for In and 'O' for Out from $transactionType
        $transactionTypeLetter = strtoupper(substr('in', 0, 1)); // Extract 'I' or 'O'

        // Get the first letter of the model name, e.g., 'E' for 'Expense'
        $modelLetter = strtoupper(substr(class_basename($sell), 0, 1));

        // Generate a unique transaction ID in the desired format (TransactionType + ModelNameFirstLetter + Random)
        do {
            $transactionId = "S".$transactionTypeLetter . $modelLetter . Str::upper(Str::random(7));
        } while (AccountTransaction::where('transaction_id', $transactionId)->exists());

        // Create a new account transaction for every status change
        AccountTransaction::create([
            'account_id' => $sell->account_id,
            'transaction_id' =>$transactionId,
            'transaction_type' => 'in',
            'amount' => $convertedData['paid_amount'],
            'model' => get_class($sell),
            'model_id' => $sell->id,
            'reference' => $reference,
        ]);
        UpdateAccountBalanceJob::dispatch();


        return redirect()->route('admin.sells.index')->with('success', 'Sell created successfully');
    }

    public function edit($id)
    {
        $sell = Sell::find($id);
        $stockProducts = ProductStock::with('product', 'showroom')->get();
        $productCategories = ProductCategory::all();
        $currencies = Currency::all();
        $salesman = Admin::where('type', '=', 'salesman')->get();
        $customers = Customer::all();
        $accounts = Account::all();

        // Retrieve selected products for the sale
        $existingProducts = SellStock::with(['stock','stock.product'])->where('sell_id', $sell->id)->get();


        return view('admin.sells.edit',
            compact('sell', 'stockProducts', 'productCategories', 'currencies', 'salesman', 'customers', 'existingProducts', 'accounts'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $currency_id = session('currency')['id'];
        $selectedCurrency = Currency::find($currency_id);
        if (!$selectedCurrency) {
            return redirect()->route('admin.sells.create')->with('error','Currency not found');
        }
        // Validate the request
        $request->validate([
            'customer' => 'required',
            'salesman' => 'required',
            'stock_id' => 'required|array',
            'stock_id.*' => 'exists:product_stocks,id',
            'product_price' => 'required|array',
            'product_quantity' => 'required|array',
            'discount_type' => 'required|array',
            'discount_amount' => 'required|array',
            'product_total' => 'required|array',
            'account_id' => 'required',
        ]);

        // Calculate totals
        $totalAmount = array_sum($request->product_total);
        $discountAmount = array_sum($request->discount_amount);
        $netTotal = $totalAmount - $discountAmount;

        // Determine the paid amount based on the request
        $paidAmount = 0; // Default value

        // Find the sell record and update
        $sell = Sell::findOrFail($id);
        $convertedData = getDefaultCurrencyConvertedPrice($sell);
        $reference = sprintf(
            '%s sale has been updated with a status of "%s" for %s (Customer) by %s (Salesman) with reference ID: %s.',
            class_basename($sell),        // Model's class name without the namespace
            $sell->status,                // Current status of the sale (e.g., "approved")
            $sell->customer->name,        // Customer's name associated with the sale
            $sell->salesman->name,        // Salesman's name associated with the sale
            $sell->unique_sale_id         // Unique sale ID with "INV" prefix
        );
        // Get 'I' for In and 'O' for Out from $transactionType
        $transactionTypeLetter = strtoupper(substr('out', 0, 1)); // Extract 'I' or 'O'

        // Get the first letter of the model name, e.g., 'E' for 'Expense'
        $modelLetter = strtoupper(substr(class_basename($sell), 0, 1));

        // Generate a unique transaction ID in the desired format (TransactionType + ModelNameFirstLetter + Random)
        do {
            $transactionId = "S".$transactionTypeLetter . $modelLetter . Str::upper(Str::random(7));
        } while (AccountTransaction::where('transaction_id', $transactionId)->exists());

        // Create a new account transaction for every status change
        AccountTransaction::create([
            'account_id' => $sell->account_id,
            'transaction_id' =>$transactionId,
            'transaction_type' => 'out',
            'amount' => $convertedData['paid_amount'],
            'model' => get_class($sell),
            'model_id' => $sell->id,
            'reference' => $reference,
        ]);
        UpdateAccountBalanceJob::dispatch();


        $sell->update([
            'customer_id' => $request->customer,
            'salesman_id' => $request->salesman,
            'account_id' => $request->account_id,
            'currency_id'=>$currency_id,
            'total_amount' => $totalAmount,
            'discount_amount' => $discountAmount,
            'net_total' => $netTotal,
            'paid_amount' => $paidAmount,
        ]);

        // Retrieve all related sell_stocks
        $sellStocks = SellStock::where('sell_id', $sell->id)->get();
        // Loop through each sell_stock and update ProductStock quantity
        foreach ($sellStocks as $sellStock) {
            ProductStock::where('id', $sellStock->stock_id)->increment('quantity', $sellStock->quantity);
        }
        SellStock::where('sell_id', $sell->id)->delete();

        foreach ($request->stock_id as $key => $stockId) {
            // Retrieve the product stock only once
            $productStock = ProductStock::find($stockId);
            // Calculate the initial total without discount
            $initialTotal = $request->product_price[$key] * $request->product_quantity[$key];

            // Apply discount based on type
            if ($request->discount_type[$key] == 'percentage') {
                $discountAmount = $initialTotal * ($request->discount_amount[$key] / 100);
            } else { // 'fixed' discount type
                $discountAmount = $request->discount_amount[$key]??0;
            }

            // Calculate final total after discount
            $finalTotal = $initialTotal - $discountAmount;

            // Insert into the sell_stocks table
            DB::table('sell_stocks')->insert([
                'sell_id' => $sell->id,
                'stock_id' => $stockId,
                'currency_id'=>$currency_id,
                'cost' => $productStock->total_cost_price * $request->product_quantity[$key],
                'price' => $request->product_price[$key],
                'quantity' => $request->product_quantity[$key],
                'discount_type' => $request->discount_type[$key],
                'discount_amount' => $discountAmount,
                'total' => $finalTotal
            ]);

            // Update the quantity in the ProductStock table
            $productStock->decrement('quantity', $request->product_quantity[$key]);
        }
        // Retrieve all required sums in a single query
        $sellStockSums = SellStock::where('sell_id', $sell->id)
            ->selectRaw('SUM(price * quantity) as total_price')
            ->selectRaw('SUM(discount_amount) as total_discount')
            ->selectRaw('SUM(total) as net_total')
            ->first();

        if ($request->paidAmountOption == 'paid_in_full') {
            $paidAmount = $sellStockSums->net_total; // Set to net total when paid in full
        } elseif ($request->paidAmountOption == 'custom_amount') { // Update this line
            $paidAmount = $request->amount; // Use the correct input name
        }

        // Update the Sell record with calculated values
        $sell->update([
            'total_amount' => $sellStockSums->total_price,
            'discount_amount' => $sellStockSums->total_discount,
            'net_total' => $sellStockSums->net_total,
            'paid_amount'=> $paidAmount
        ]);
        $sell = Sell::find($sell->id);
        $convertedData = getDefaultCurrencyConvertedPrice($sell);
        $reference = sprintf(
            '%s sale has been updated with a status of "%s" for %s (Customer) by %s (Salesman) with reference ID: %s.',
            class_basename($sell),        // Model's class name without the namespace
            $sell->status,                // Current status of the sale (e.g., "approved")
            $sell->customer->name,        // Customer's name associated with the sale
            $sell->salesman->name,        // Salesman's name associated with the sale
            $sell->unique_sale_id         // Unique sale ID with "INV" prefix
        );
        // Get 'I' for In and 'O' for Out from $transactionType
        $transactionTypeLetter = strtoupper(substr('in', 0, 1)); // Extract 'I' or 'O'

        // Get the first letter of the model name, e.g., 'E' for 'Expense'
        $modelLetter = strtoupper(substr(class_basename($sell), 0, 1));

        // Generate a unique transaction ID in the desired format (TransactionType + ModelNameFirstLetter + Random)
        do {
            $transactionId = "S".$transactionTypeLetter . $modelLetter . Str::upper(Str::random(7));
        } while (AccountTransaction::where('transaction_id', $transactionId)->exists());

        // Create a new account transaction for every status change
        AccountTransaction::create([
            'account_id' => $sell->account_id,
            'transaction_id' =>$transactionId,
            'transaction_type' => 'in',
            'amount' => $convertedData['paid_amount'],
            'model' => get_class($sell),
            'model_id' => $sell->id,
            'reference' => $reference,
        ]);
        UpdateAccountBalanceJob::dispatch();

        return redirect()->route('admin.sells.index')->with('success', 'Sell updated successfully');
    }


    public function destroy($id): RedirectResponse
    {
        $sell = Sell::find($id);
        // Retrieve all related sell_stocks
        $sellStocks = SellStock::where('sell_id', $sell->id)->get();

        // Loop through each sell_stock and update ProductStock quantity
        foreach ($sellStocks as $sellStock) {
            ProductStock::where('id', $sellStock->stock_id)->increment('quantity', $sellStock->quantity);
        }
        $reference = sprintf(
            '%s sale has been deleted with a status of "%s" for %s (Customer) by %s (Salesman) with reference ID: %s.',
            class_basename($sell),        // Model's class name without the namespace
            $sell->status,                // Current status of the sale (e.g., "approved")
            $sell->customer->name,        // Customer's name associated with the sale
            $sell->salesman->name,        // Salesman's name associated with the sale
            $sell->unique_sale_id         // Unique sale ID with "INV" prefix
        );
        // Get 'I' for In and 'O' for Out from $transactionType
        $transactionTypeLetter = strtoupper(substr('out', 0, 1)); // Extract 'I' or 'O'

        // Get the first letter of the model name, e.g., 'E' for 'Expense'
        $modelLetter = strtoupper(substr(class_basename($sell), 0, 1));

        // Generate a unique transaction ID in the desired format (TransactionType + ModelNameFirstLetter + Random)
        do {
            $transactionId = "S".$transactionTypeLetter . $modelLetter . Str::upper(Str::random(7));
        } while (AccountTransaction::where('transaction_id', $transactionId)->exists());

        // Create a new account transaction for every status change
        AccountTransaction::create([
            'account_id' => $sell->account_id,
            'transaction_id' =>$transactionId,
            'transaction_type' => 'out',
            'amount' => $sell->paid_amount,
            'model' => get_class($sell),
            'model_id' => $sell->id,
            'reference' => $reference,
        ]);
        UpdateAccountBalanceJob::dispatch();
        $sell->delete();
        return redirect()->route('admin.sells.index')->with('success', 'Sell Deleted Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $sell = Sell::findOrFail($id);
        $existingProducts = SellStock::with('currency')->where('sell_id', $sell->id)->get();
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Sell::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.sells.show', compact('sell', 'admins', 'activities', 'existingProducts'));
    }

    public function restore($id): RedirectResponse
    {
        $sell = Sell::withTrashed()->find($id);
        // Retrieve all related sell_stocks
        $sellStocks = SellStock::where('sell_id', $sell->id)->get();

        // Loop through each sell_stock and update ProductStock quantity
        foreach ($sellStocks as $sellStock) {
            ProductStock::where('id', $sellStock->stock_id)->decrement('quantity', $sellStock->quantity);
        }
        $sell->restore();
        $reference = sprintf(
            '%s sale has been restored with a status of "%s" for %s (Customer) by %s (Salesman) with reference ID: %s.',
            class_basename($sell),        // Model's class name without the namespace
            $sell->status,                // Current status of the sale (e.g., "approved")
            $sell->customer->name,        // Customer's name associated with the sale
            $sell->salesman->name,        // Salesman's name associated with the sale
            $sell->unique_sale_id         // Unique sale ID with "INV" prefix
        );
        // Get 'I' for In and 'O' for Out from $transactionType
        $transactionTypeLetter = strtoupper(substr('in', 0, 1)); // Extract 'I' or 'O'

        // Get the first letter of the model name, e.g., 'E' for 'Expense'
        $modelLetter = strtoupper(substr(class_basename($sell), 0, 1));

        // Generate a unique transaction ID in the desired format (TransactionType + ModelNameFirstLetter + Random)
        do {
            $transactionId = "S".$transactionTypeLetter . $modelLetter . Str::upper(Str::random(7));
        } while (AccountTransaction::where('transaction_id', $transactionId)->exists());

        // Create a new account transaction for every status change
        AccountTransaction::create([
            'account_id' => $sell->account_id,
            'transaction_id' =>$transactionId,
            'transaction_type' => 'in',
            'amount' => $sell->paid_amount,
            'model' => get_class($sell),
            'model_id' => $sell->id,
            'reference' => $reference,
        ]);
        UpdateAccountBalanceJob::dispatch();
        return redirect()->route('admin.sells.index')->with('success', 'Sell Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $sell = Sell::withTrashed()->find($id);
        $sellStock = SellStock::where('sell_id', $sell->id)->get();
        foreach ($sellStock as $stock) {
            $stock->delete();
        }
        $sell->forceDelete();
        return redirect()->route('admin.sells.trashed')->with('success', 'Sell Permanently Deleted');
    }

    public function getProductsByCategory(Request $request)
    {
        $categoryId = $request->get('category_id');

        // Fetch ProductStock records where the related product belongs to the specified category
        $productStocks = ProductStock::whereHas('product', function($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })->with(['product', 'product_sell_prices'])->get();  // Include sell prices

        // Map through the productStocks and return the full product information with quantity and sell prices
        $productsWithQuantity = $productStocks->map(function($stock) {
        // Get the sell prices for the current product stock
        $sellPrices = $stock->product_sell_prices;

            return [
                'stock'=>$stock,
                'product' => $stock->product,  // All product information
                'quantity' => $stock->quantity, // Stock quantity
                'sell_prices' => $sellPrices->map(function($sellPrice) {
                    return [
                        'currency_id' => $sellPrice->currency_id,
                        'price' => $sellPrice->sell_price,
                    ];
                }),
            ];
        });

        return response()->json(['products' => $productsWithQuantity]);
    }

    public function getAllProducts()
    {
        // Fetch all ProductStock records with the related Product model
        $productStocks = ProductStock::with('product', 'product_sell_prices')->get();

        // Map through the productStocks and return the full product information with quantity
        $productsWithQuantity = $productStocks->map(function($stock) {

        // Get the sell prices for the current product stock
        $sellPrices = $stock->product_sell_prices;

            return [
                'stock'=>$stock,
                'product' => $stock->product,  // All product information
                'quantity' => $stock->quantity, // Stock quantity
                'sell_prices' => $sellPrices->map(function($sellPrice) {
                    return [
                        'currency_id' => $sellPrice->currency_id,
                        'price' => $sellPrice->sell_price,
                    ];
                }),
            ];
        });

        return response()->json(['products' => $productsWithQuantity]);
    }

    public function showInvoice($id) {
        $sell = Sell::with(['customer', 'salesman'])->findOrFail($id);
        $existingProducts = DB::table('sell_stocks')->where('sell_id', $sell->id)->get();

        return view('admin.sells.invoice', compact('sell', 'existingProducts'));
    }
}
