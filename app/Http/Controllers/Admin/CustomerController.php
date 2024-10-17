<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        $customers = Customer::orderBy('id', 'DESC')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $customers = Customer::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.customers.trashed', compact('customers'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'dob' => $request->dob,
            'anniversary_date' => $request->anniversary_date,
            'registration_date' => $request->registration_date,
            'family_details' => json_encode($request->only(['relation_type', 'family_name', 'family_age'])),
        ]);
        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $customer = Customer::find($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $customer = Customer::find($id);
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'dob' => $request->dob,
            'anniversary_date' => $request->anniversary_date,
            'registration_date' => $request->registration_date,
            'family_details' => json_encode($request->only(['relation_type', 'family_name', 'family_age'])),
        ]);
        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $customer = Customer::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Customer::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.customers.show', compact('customer', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $customer = Customer::withTrashed()->find($id);
        $customer->restore();
        return redirect()->route('admin.customers.index')->with('success', 'Customer restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $customer = Customer::withTrashed()->find($id);
        $customer->forceDelete();
        return redirect()->route('admin.customers.trashed')->with('success', 'Customer permanently deleted.');
    }

}
