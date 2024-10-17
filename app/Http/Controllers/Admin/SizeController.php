<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class SizeController extends Controller
{
    public function index(): View|Factory|Application
    {
        $sizes = Size::orderBy('id', 'DESC')->get();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $sizes = Size::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.sizes.trashed', compact('sizes'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);
        $size = Size::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.sizes.index')->with('success', 'Size created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $size = Size::find($id);
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $size = Size::find($id);
        $request->validate([
            'name' => 'required',
        ]);
        $size->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.sizes.index')->with('success', 'Size updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $size = Size::find($id);
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Size deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $size = Size::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Size::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.sizes.show', compact('size', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $size = Size::withTrashed()->find($id);
        $size->restore();
        return redirect()->route('admin.sizes.index')->with('success', 'Size restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $size = Size::withTrashed()->find($id);
        $size->forceDelete();
        return redirect()->route('admin.sizes.trashed')->with('success', 'Size Permanently Deleted');
    }
}
