<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\ExpenseCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\Sell;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SellController extends Controller
{
    public function index(): View|Factory|Application
    {
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
        // Validate the request
        $request->validate([
            'customer' => 'required',
            'salesman' => 'required',
            'account_id' => 'required',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
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

        // Create the sell record
        $sell = Sell::create([
            'customer_id' => $request->customer,
            'salesman_id' => $request->salesman,
            'account_id' => $request->account_id,
            'total_amount' => $totalAmount,
            'discount_amount' => $discountAmount,
            'net_total' => $netTotal,
        ]);

        // Loop through products and save them to the sells_product table
        foreach ($request->product_id as $key => $productId) {
            DB::table('sells_product')->insert([
                'sell_id' => $sell->id,
                'product_id' => $productId,
                'price' => $request->product_price[$key],
                'quantity' => $request->product_quantity[$key],
                'discount_type' => $request->discount_type[$key],
                'discount_amount' => $request->discount_amount[$key],
                'total' => $request->product_total[$key]
            ]);
        }

        return redirect()->route('admin.sells.index')->with('success', 'Sell created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        $sell = Sell::find($id);
        $stockProducts = ProductStock::with('product', 'showroom')->get();
        $productCategories = ProductCategory::all();
        $currencies = Currency::all();
        $salesman = Admin::where('type', '=', 'salesman')->get();
        $customers = Customer::all();
        $accounts = Account::all();

        // Retrieve selected products for the sale
        $existingProducts = DB::table('sells_product')->where('sell_id', $sell->id)->get();

        return view('admin.sells.edit',
            compact('sell', 'stockProducts', 'productCategories', 'currencies', 'salesman', 'customers', 'existingProducts', 'accounts'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'customer' => 'required',
            'salesman' => 'required',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
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

        // Find the sell record and update
        $sell = Sell::findOrFail($id);
        $sell->update([
            'customer_id' => $request->customer,
            'salesman_id' => $request->salesman,
            'account_id' => $request->account_id,
            'total_amount' => $totalAmount,
            'discount_amount' => $discountAmount,
            'net_total' => $netTotal,
        ]);

        // Retrieve existing product entries for the sell
        $existingProducts = DB::table('sells_product')
            ->where('sell_id', $id)
            ->whereNull('deleted_at')
            ->get()
            ->keyBy('product_id');

        // Loop through provided products in the request
        foreach ($request->product_id as $key => $productId) {
            $productData = [
                'sell_id' => $id,
                'product_id' => $productId,
                'price' => $request->product_price[$key],
                'quantity' => $request->product_quantity[$key],
                'discount_type' => $request->discount_type[$key],
                'discount_amount' => $request->discount_amount[$key],
                'total' => $request->product_total[$key],
            ];

            if ($existingProducts->has($productId)) {
                // Update existing product entry if data has changed
                $existingProduct = $existingProducts[$productId];
                $hasChanges = $existingProduct->price != $productData['price'] ||
                    $existingProduct->quantity != $productData['quantity'] ||
                    $existingProduct->discount_type != $productData['discount_type'] ||
                    $existingProduct->discount_amount != $productData['discount_amount'] ||
                    $existingProduct->total != $productData['total'];

                if ($hasChanges) {
                    DB::table('sells_product')
                        ->where('sell_id', $id)
                        ->where('product_id', $productId)
                        ->update($productData);
                }

                // Remove this product from the existing products list
                $existingProducts->forget($productId);
            } else {
                // Insert new product entry if it doesn't exist
                DB::table('sells_product')->insert($productData);
            }
        }

        // Soft-delete any remaining products that were not in the request
        foreach ($existingProducts as $remainingProduct) {
            DB::table('sells_product')
                ->where('sell_id', $id)
                ->where('product_id', $remainingProduct->product_id)
                ->update(['deleted_at' => now()]);
        }

        return redirect()->route('admin.sells.index')->with('success', 'Sell updated successfully');
    }


    public function destroy($id): RedirectResponse
    {
        $sell = Sell::find($id);
        $sell->delete();
        return redirect()->route('admin.sells.index')->with('success', 'Sell Deleted Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $sell = Sell::findOrFail($id);
        $existingProducts = DB::table('sells_product')->where('sell_id', $sell->id)->get();
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Sell::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.sells.show', compact('sell', 'admins', 'activities', 'existingProducts'));
    }

    public function restore($id): RedirectResponse
    {
        $sell = Sell::withTrashed()->find($id);
        $sell->restore();
        return redirect()->route('admin.sells.index')->with('success', 'Sell Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $sell = Sell::withTrashed()->find($id);
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
        $existingProducts = DB::table('sells_product')->where('sell_id', $sell->id)->get();

        return view('admin.sells.invoice', compact('sell', 'existingProducts'));
    }
}
