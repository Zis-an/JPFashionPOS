<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateSupplierBalance;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    public function index(): View|Factory|Application
    {
        UpdateSupplierBalance::dispatch();
        $suppliers = Supplier::orderBy('id', 'DESC')->get();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function trashed_list(): View|Factory|Application
    {
        UpdateSupplierBalance::dispatch();
        $suppliers = Supplier::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.suppliers.trashed', compact('suppliers'));
    }

    public function create(): View|Factory|Application
    {
        UpdateSupplierBalance::dispatch();
        return view('admin.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);
        $supplier = Supplier::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person ?? '',
            'phone' => $request->phone ?? '',
            'email' => $request->email,
            'address' => $request->address ?? '',
            'description' => $request->description ?? ''
        ]);
        UpdateSupplierBalance::dispatch();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        UpdateSupplierBalance::dispatch();
        $supplier = Supplier::find($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $supplier = Supplier::find($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);
        $supplier->update([
            'name' => $request->name ?? $supplier->name,
            'contact_person' => $request->contact_person ?? $supplier->contact_person,
            'phone' => $request->phone ?? $supplier->phone,
            'email' => $request->email ?? $supplier->email,
            'address' => $request->address ?? $supplier->address,
            'description' => $request->description ?? $supplier->description
        ]);
        UpdateSupplierBalance::dispatch();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        UpdateSupplierBalance::dispatch();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $supplier = Supplier::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Supplier::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        UpdateSupplierBalance::dispatch();
        return view('admin.suppliers.show', compact('supplier', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $supplier = Supplier::withTrashed()->find($id);
        $supplier->restore();
        UpdateSupplierBalance::dispatch();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $supplier = Supplier::withTrashed()->find($id);
        $supplier->forceDelete();
        UpdateSupplierBalance::dispatch();
        return redirect()->route('admin.suppliers.trashed')->with('success', 'Supplier Permanently Deleted');
    }
}
