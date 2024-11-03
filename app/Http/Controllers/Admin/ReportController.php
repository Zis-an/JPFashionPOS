<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\RawMaterial;
use App\Models\RawMaterialStock;
use App\Models\Sell;
use App\Models\Showroom;
use App\Models\Size;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function rawMaterialStockReports(Request $request)
    {
        // Get all relevant data for filters
        $rawMaterials = RawMaterial::all();
        $warehouses = Warehouse::all();
        $colors = Color::all();
        $brands = Brand::all();
        $sizes = Size::all();

        // Start building the query
        $query = RawMaterialStock::with(['raw_material', 'warehouse', 'color', 'brand', 'size']);

        // Apply filters based on the request
        if ($request->filled('materialId')) {
            $query->where('raw_material_id', $request->materialId);
        }
        if ($request->filled('warehouseId')) {
            $query->where('warehouse_id', $request->warehouseId);
        }
        if ($request->filled('colorId')) {
            $query->where('color_id', $request->colorId);
        }
        if ($request->filled('brandId')) {
            $query->where('brand_id', $request->brandId);
        }
        if ($request->filled('sizeId')) {
            $query->where('size_id', $request->sizeId);
        }

        // Filter by start and end dates
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
        } elseif ($request->filled('startDate')) {
            $query->whereDate('created_at', '>=', $request->startDate);
        } elseif ($request->filled('endDate')) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }

        // Get the filtered stocks
        $stocks = $query->get();

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json(['stocks' => $stocks]);
        }

        return view('admin.reports.rawMaterialStocks', compact('stocks', 'rawMaterials', 'warehouses', 'colors', 'brands', 'sizes'));
    }
    public function productStockReports(Request $request)
    {
        // Get all relevant data for filters
        $products = Product::all();
        $showrooms = Showroom::all();
        $colors = Color::all();
        $brands = Brand::all();
        $sizes = Size::all();

        // Start building the query
        $query = ProductStock::with(['product', 'color', 'brand', 'size', 'showroom']);

        // Apply filters based on the request
        if ($request->filled('productId')) {
            $query->where('product_id', $request->productId);
        }
        if ($request->filled('showroomId')) {
            $query->where('showroom_id', $request->showroomId);
        }
        if ($request->filled('colorId')) {
            $query->where('color_id', $request->colorId);
        }
        if ($request->filled('brandId')) {
            $query->where('brand_id', $request->brandId);
        }
        if ($request->filled('sizeId')) {
            $query->where('size_id', $request->sizeId);
        }

        // Filter by start and end dates
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
        } elseif ($request->filled('startDate')) {
            $query->whereDate('created_at', '>=', $request->startDate);
        } elseif ($request->filled('endDate')) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }

        // Get the filtered stocks
        $stocks = $query->get();

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json(['stocks' => $stocks]);
        }

        return view('admin.reports.productStocks', compact('stocks', 'products', 'showrooms', 'colors', 'brands', 'sizes'));
    }
    public function sellReports(Request $request)
    {
        // Get all relevant data for filters
        $customers = Customer::all();
        $salesmen = Admin::where('type', '=', 'salesman')->get();
        $accounts = Account::all();

        // Start building the query
        $query = Sell::with(['customer', 'salesman', 'account']);

        // Apply filters based on the request
        if ($request->filled('customerId')) {
            $query->where('customer_id', $request->customerId);
        }
        if ($request->filled('salesmanId')) {
            $query->where('salesman_id', $request->salesmanId);
        }
        if ($request->filled('accountId')) {
            $query->where('account_id', $request->accountId);
        }

        // Filter by start and end dates
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
        } elseif ($request->filled('startDate')) {
            $query->whereDate('created_at', '>=', $request->startDate);
        } elseif ($request->filled('endDate')) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }

        // Get the filtered stocks
        $sells = $query->get();

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json(['sells' => $sells]);
        }

        return view('admin.reports.sells', compact('sells', 'customers', 'accounts', 'salesmen'));
    }
    public function assetReports(){return view('admin.reports.assets');}
    public function expenseReports(){return view('admin.reports.expenses');}
    public function rawMaterialPurchaseReports(){return view('admin.reports.rawMaterialPurchases');}
    public function balanceSheetReports(){return view('admin.reports.balanceSheets');}
    public function depositBalanceSheet(){return view('admin.reports.depositBalanceSheets');}
    public function withdrawBalanceSheet(){return view('admin.reports.withdrawBalanceSheets');}
    public function transferBalanceSheet(){return view('admin.reports.transferBalanceSheets');}
}
