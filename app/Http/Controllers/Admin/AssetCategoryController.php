<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AssetCategoryController extends Controller
{
    public function index(): View|Factory|Application
    {
        $categories = AssetCategory::orderBy('id', 'DESC')->get();
        return view('admin.asset-categories.index', compact('categories'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $categories = AssetCategory::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.asset-categories.trashed', compact('categories'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.asset-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category = AssetCategory::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.asset-categories.index')->with('success', 'Asset Category created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        $category = AssetCategory::find($id);
        return view('admin.asset-categories.edit', compact('category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $category = AssetCategory::find($id);
        $request->validate([
            'name' => 'required',
        ]);
        $category->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.asset-categories.index')->with('success', 'Asset Category Updated Successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $category = AssetCategory::find($id);
        $category->delete();
        return redirect()->route('admin.asset-categories.index')->with('success', 'Asset Category Deleted Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $category = AssetCategory::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(AssetCategory::class, $id)
            ->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.asset-categories.show', compact('category', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $category = AssetCategory::withTrashed()->find($id);
        $category->restore();
        return redirect()->route('admin.asset-categories.index')->with('Asset Category Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $category = AssetCategory::withTrashed()->find($id);
        $category->forceDelete();
        return redirect()->route('admin.asset-categories.trashed')->with('success', 'Asset Category Permanently Deleted');
    }
}
