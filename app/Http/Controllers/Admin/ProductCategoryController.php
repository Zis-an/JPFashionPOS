<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ProductCategoryController extends Controller
{
    public function index(): View|Factory|Application
    {
        $categories = ProductCategory::with('allChildren')->whereNull('parent_id')->get();
        return view('admin.productCategories.index', compact('categories'));
    }

    public function create(): View|Factory|Application
    {
        $categories = ProductCategory::all();
        return view('admin.productCategories.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);
        $category = ProductCategory::create([
            'name' => $request['name']
        ]);
        return redirect()->route('admin.productCategories.index')->with('success', 'Product Category created successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $category = ProductCategory::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(ProductCategory::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.productCategories.show', compact('category', 'admins', 'activities'));
    }

    public function edit($id): View|Factory|Application
    {
        $category = ProductCategory::find($id);
        return view('admin.productCategories.edit', compact('category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $category = ProductCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:product_categories,id',
        ]);
        $category->update([
            'name' => $request['name']
        ]);
        return redirect()->route('admin.productCategories.index')->with('success', 'Product Category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->delete();
        return redirect()->route('admin.productCategories.index')->with('success', 'Product Category deleted successfully.');
    }

    public function trashed_list(): View|Factory|Application
    {
        $categories = ProductCategory::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.productCategories.trashed', compact('categories'));
    }

    public function restore($id): RedirectResponse
    {
        $category = ProductCategory::withTrashed()->find($id);
        $category->restore();
        return redirect()->route('admin.productCategories.index')->with('success','Product Category restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $category = ProductCategory::withTrashed()->find($id);
        $category->forceDelete();
        return redirect()->route('admin.productCategories.trashed')->with('success','Product Category Permanently Deleted');
    }
}

