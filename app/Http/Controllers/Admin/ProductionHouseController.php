<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateProductionHouseBalance;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Brand;
use App\Models\ProductionHouse;
use App\Models\ProductCategory;
use App\Models\Unit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductionHouseController extends Controller
{
    public function index(): View|Factory|Application
    {
        UpdateProductionHouseBalance::dispatch();
        $houses = ProductionHouse::orderBy('id', 'DESC')->get();
        return view('admin.houses.index', compact('houses'));
    }

    public function trashed_list(): View|Factory|Application
    {
        UpdateProductionHouseBalance::dispatch();
        $houses = ProductionHouse::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.houses.trashed', compact('houses'));
    }

    public function create(): View|Factory|Application
    {
        UpdateProductionHouseBalance::dispatch();
        return view('admin.houses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $house = ProductionHouse::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email')
        ]);

        UpdateProductionHouseBalance::dispatch();
        return redirect()->route('admin.houses.index')->with('success', 'Production House created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        UpdateProductionHouseBalance::dispatch();
        $house = ProductionHouse::find($id);
        return view('admin.houses.edit', compact('house'));
    }

    public function update(Request $request, ProductionHouse $house): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'status' => 'required',
        ]);

        // Update house
        $house->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'status' => $request->input('status')
        ]);
        UpdateProductionHouseBalance::dispatch();
        return redirect()->route('admin.houses.index')->with('success', 'Production House updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $house = ProductionHouse::find($id);
        $house->delete();
        UpdateProductionHouseBalance::dispatch();
        return redirect()->route('admin.houses.index')->with('success', 'Production House Deleted Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $house = ProductionHouse::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(ProductionHouse::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        UpdateProductionHouseBalance::dispatch();
        return view('admin.houses.show', compact('house', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $house = ProductionHouse::withTrashed()->find($id);
        $house->restore();
        UpdateProductionHouseBalance::dispatch();
        return redirect()->route('admin.houses.index')->with('Production House Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $house = ProductionHouse::withTrashed()->find($id);
        $house->forceDelete();
        UpdateProductionHouseBalance::dispatch();
        return redirect()->route('admin.houses.trashed')->with('success', 'Production House Permanently Deleted');
    }
}
