<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class PaymentMethodController extends Controller
{
    public function index(): View|Factory|Application
    {
        $paymentMethods = PaymentMethod::orderBy('id', 'DESC')->get();
        return view('admin.paymentMethods.index', compact('paymentMethods'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.paymentMethods.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:payment_methods,name',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
        $amount = filter_var($request->amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $category = PaymentMethod::create([
            'name' => $request->name,
            'amount' => $amount,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.paymentMethods.index')->with('success', 'Payment method created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        $paymentMethod = paymentMethod::find($id);
        return view('admin.paymentMethods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $paymentMethod = paymentMethod::find($id);
        $request->validate([
            'name' => 'required|unique:payment_methods,name,'.$paymentMethod->id,
            'amount' => 'required'
        ]);
        $paymentMethod->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.paymentMethods.index')->with('success', 'Payment method Updated Successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $paymentMethod = paymentMethod::find($id);
        $paymentMethod->delete();
        return redirect()->route('admin.paymentMethods.index')->with('success', 'Payment method Deleted Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $paymentMethod = paymentMethod::findOrFail($id);
        $admins = Admin::all();
        // Retrieve activities for the account
        $activities = AdminActivity::getActivities(paymentMethod::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.paymentMethods.show', compact('paymentMethod', 'admins', 'activities'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $paymentMethods = paymentMethod::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.paymentMethods.trashed', compact('paymentMethods'));
    }

    public function restore($id): RedirectResponse
    {
        $paymentMethod = paymentMethod::withTrashed()->find($id);
        $paymentMethod->restore();
        return redirect()->route('admin.paymentMethods.index')->with('Payment method restored successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $paymentMethod = paymentMethod::withTrashed()->find($id);
        $paymentMethod->forceDelete();
        return redirect()->route('admin.paymentMethods.trashed')->with('Payment method Permanently Deleted');
    }
}
