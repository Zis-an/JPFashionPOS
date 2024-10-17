<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\RawMaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class RawMaterialCategoryController extends Controller
{
    public function index(): View|Factory|Application
    {
        $categories = RawMaterialCategory::orderBy('id', 'DESC')->latest()->get();
        return view('admin.materialCategories.index', compact('categories'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.materialCategories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:raw_material_categories,name',
        ]);
        RawMaterialCategory::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.materialCategories.index')->with('success', 'Raw Material Category Created Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $category = RawMaterialCategory::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(RawMaterialCategory::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.materialCategories.show', compact('category', 'admins', 'activities'));
    }

    public function edit($id): View|Factory|Application
    {
        $category = RawMaterialCategory::find($id);
        return view('admin.materialCategories.edit', compact('category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $category = RawMaterialCategory::find($id);
        $request->validate([
            'name' => 'required|unique:raw_material_categories,name,' . $id,
        ]);
        $category->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.materialCategories.index')->with('success', 'Raw Material Category Updated Successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $category = RawMaterialCategory::find($id);
        $category->delete();
        return redirect()->route('admin.materialCategories.index')->with('success', 'Raw Material Category Deleted Successfully');
    }

    public function trashed_list(): View|Factory|Application
    {
        $categories = RawMaterialCategory::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.materialCategories.trashed', compact('categories'));
    }

    public function restore($id): RedirectResponse
    {
        $category = RawMaterialCategory::withTrashed()->find($id);
        $category->restore();
        return redirect()->route('admin.materialCategories.index')->with('success', 'Raw Material Category Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $category = RawMaterialCategory::withTrashed()->find($id);
        $category->forceDelete();
        return redirect()->route('admin.materialCategories.trashed')->with('success', 'Raw Material Category Permanently Deleted');
    }
}

