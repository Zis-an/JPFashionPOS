<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Brand;
use App\Models\Color;
use App\Models\RawMaterial;
use App\Models\RawMaterialStock;
use App\Models\Size;
use App\Models\Warehouse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RawMaterialStockController extends Controller
{
    public function index(): View|Factory|Application
    {
        $stocks = RawMaterialStock::orderBy('id', 'DESC')->latest()->get();
        return view('admin.rawMaterialStocks.index', compact('stocks'));
    }

    public function create(): View|Factory|Application
    {
        $materials = RawMaterial::all();
        $colors = Color::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $warehouses = Warehouse::all();
        return view('admin.rawMaterialStocks.create', compact('materials', 'colors', 'brands', 'sizes', 'warehouses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'raw_material_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'warehouse_id' => 'required',
            'color_id' => 'required',
            'brand_id' => 'required',
            'size_id' => 'required',
        ]);

        RawMaterialStock::create([
            'raw_material_id' => $request->raw_material_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'warehouse_id' => $request->warehouse_id,
            'color_id' => $request->color_id,
            'brand_id' => $request->brand_id,
            'size_id' => $request->size_id,
        ]);

        return redirect()->route('admin.raw-material-stocks.index')->with('success', 'Stock Created Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $stock = RawMaterialStock::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(RawMaterialStock::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.rawMaterialStocks.show', compact('stock', 'admins', 'activities'));
    }

    public function edit($id): View|Factory|Application
    {
        $stock = RawMaterialStock::find($id);
        $materials = RawMaterial::all();
        $colors = Color::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $warehouses = Warehouse::all();
        return view('admin.rawMaterialStocks.edit', compact('stock', 'materials', 'colors', 'brands', 'sizes', 'warehouses'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $stock = RawMaterialStock::find($id);

        $request->validate([
            'raw_material_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'warehouse_id' => 'required',
            'color_id' => 'required',
            'brand_id' => 'required',
            'size_id' => 'required',
        ]);

        $stock->update([
            'raw_material_id' => $request->raw_material_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'warehouse_id' => $request->warehouse_id,
            'color_id' => $request->color_id,
            'brand_id' => $request->brand_id,
            'size_id' => $request->size_id,
        ]);

        return redirect()->route('admin.raw-material-stocks.index')->with('success', 'Stock Updated Successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $stock = RawMaterialStock::find($id);
        $stock->delete();
        return redirect()->route('admin.raw-material-stocks.index')->with('success', 'Stock Deleted Successfully');
    }

    public function trashed_list(): View|Factory|Application
    {
        $stocks = RawMaterialStock::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.rawMaterialStocks.trashed', compact('stocks'));
    }

    public function restore($id): RedirectResponse
    {
        $stock = RawMaterialStock::withTrashed()->find($id);
        $stock->restore();
        return redirect()->route('admin.raw-material-stocks.index')->with('success', 'Stock Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $stock = RawMaterialStock::withTrashed()->find($id);
        $stock->forceDelete();
        return redirect()->route('admin.raw-material-stocks.trashed')->with('success', 'Stock Permanently Deleted');
    }
}
