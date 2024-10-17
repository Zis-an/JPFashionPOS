<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class UnitController extends Controller
{
    public function index(): View|Factory|Application
    {
        $units = Unit::orderBy('id', 'DESC')->get();
        return view('admin.units.index', compact('units'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $units = Unit::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.units.trashed', compact('units'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.units.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required'
        ]);
        $unit = Unit::create([
            'code' => $request->code,
            'name' => $request->name
        ]);
        return redirect()->route('admin.units.index')->with('success', 'Unit created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $unit = Unit::find($id);
        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $unit = Unit::find($id);
        $request->validate([
            'code' => 'required',
            'name' => 'required'
        ]);
        $unit->update([
            'code' => $request->code,
            'name' => $request->name
        ]);
        return redirect()->route('admin.units.index')->with('success', 'Unit updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $unit = Unit::find($id);
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'Unit deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $unit = Unit::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Unit::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.units.show', compact('unit', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $unit = Unit::withTrashed()->find($id);
        $unit->restore();
        return redirect()->route('admin.units.index')->with('success', 'Unit restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $unit = Unit::withTrashed()->find($id);
        $unit->forceDelete();
        return redirect()->route('admin.units.trashed')->with('success', 'Unit Permanently Deleted');
    }
}
