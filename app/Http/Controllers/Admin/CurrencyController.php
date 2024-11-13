<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Currency;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(): View|Factory|Application
    {
        $currencies = Currency::orderBy('id', 'DESC')->get();
        return view('admin.currencies.index', compact('currencies'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $currencies = Currency::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.currencies.trashed', compact('currencies'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'rate' => 'required',
        ]);

        $currency = Currency::create([
            'code' => $request->code,
            'name' => $request->name,
            'rate' => $request->rate,
            'suffix' => $request->suffix,
            'prefix' => $request->prefix,
        ]);
        return redirect()->route('admin.currencies.index')->with('success', 'Currency created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        $currency = Currency::find($id);
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $currency = Currency::findOrFail($id);
            $request->validate([
                'code' => 'required',
                'name' => 'required',
                'rate' => 'required',
                'status' => 'required',
            ]);
            $currency->update([
                'code' => $request->code,
                'name' => $request->name,
                'rate' => $request->rate,
                'suffix' => $request->suffix,
                'prefix' => $request->prefix,
                'status' => $request->status,
            ]);
            return redirect()->route('admin.currencies.index')->with('success', 'Currency Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $currency = Currency::findOrFail($id);
            if (!$currency->is_default){
                $currency->delete();
                return redirect()->route('admin.currencies.index')->with('success', 'Currency Deleted Successfully');
            }else{
                return redirect()->route('admin.currencies.index')->with('error', 'Default Currency Cannot Delete');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id): View|Factory|Application
    {
        $currency = Currency::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Currency::class, $id)
            ->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.currencies.show', compact('currency', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $currency = Currency::withTrashed()->find($id);
        $currency->restore();
        return redirect()->route('admin.currencies.index')->with('Currency Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $currency = Currency::withTrashed()->find($id);
        $currency->forceDelete();
        return redirect()->route('admin.currencies.trashed')->with('success', 'Currency Permanently Deleted');
    }
}
