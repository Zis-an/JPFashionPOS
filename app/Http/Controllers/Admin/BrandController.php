<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    public function index(): View|Factory|Application
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $brands = Brand::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.brands.trashed', compact('brands'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.brands.create');
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required',
        ]);

        $brand = Brand::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $brand = Brand::find($id);
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $brand = Brand::find($id);
        $request->validate([
            'name' => 'required',
        ]);

        $brand->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $brand = Brand::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Brand::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.brands.show', compact('brand', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $brand = Brand::withTrashed()->find($id);
        $brand->restore();
        return redirect()->route('admin.brands.index')->with('success', 'Brand restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $brand = Brand::withTrashed()->find($id);
        $brand->forceDelete();
        return redirect()->route('admin.brands.trashed')->with('success', 'Brand Permanently Deleted');
    }
}
