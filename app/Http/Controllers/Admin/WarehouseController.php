<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class WarehouseController extends Controller
{
    public function index(): View|Factory|Application
    {
        $warehouses = Warehouse::orderBy('id', 'DESC')->get();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.warehouses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:warehouses,name',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'nullable|string',
        ]);
        Warehouse::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status ?? 'active',
        ]);
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        $warehouse = Warehouse::find($id);
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $warehouse = Warehouse::find($id);
        $request->validate([
            'name' => 'required|unique:warehouses,name,'.$warehouse->id,
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'nullable|string',
        ]);
        $warehouse->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status ?? 'active',
        ]);
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $warehouse = Warehouse::find($id);
        $warehouse->delete();
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse deleted successfully');
    }

    public function show($id): View|Factory|Application
    {
        $warehouse = Warehouse::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Warehouse::class, $id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('admin.warehouses.show', compact('warehouse', 'admins', 'activities'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $warehouses = Warehouse::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.warehouses.trashed', compact('warehouses'));
    }

    public function restore($id): RedirectResponse
    {
        $warehouse = Warehouse::withTrashed()->find($id);
        $warehouse->restore();
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse restored successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $warehouse = Warehouse::withTrashed()->find($id);
        $warehouse->forceDelete();
        return redirect()->route('admin.warehouses.trashed')->with('success', 'Warehouse permanently deleted');
    }
}
