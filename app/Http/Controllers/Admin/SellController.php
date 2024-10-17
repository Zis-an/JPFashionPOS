<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\ExpenseCategory;
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
        return view('admin.sells.create');
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
}
