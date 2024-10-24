<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Currency;
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
        return view('admin.sells.create', compact('stockProducts', 'productCategories', 'currencies'));
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
        $request->validate([
            'name' => 'required',
        ]);
        $sells = Sell::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.sells.index')->with('success', 'Sell created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        $sell = Sell::find($id);
        return view('admin.sells.edit', compact('sell'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $sell = Sell::find($id);
        $request->validate([
            'name' => 'required',
        ]);
        $sell->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.sells.index')->with('success', 'Sell Updated Successfully');
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
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Sell::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.sells.show', compact('sell', 'admins', 'activities'));
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
}
