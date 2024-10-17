<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ExpenseCategoryController extends Controller
{
    public function index(): View|Factory|Application
    {
        $categories = ExpenseCategory::orderBy('id', 'DESC')->get();
        return view('admin.expense-categories.index', compact('categories'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $categories = ExpenseCategory::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.expense-categories.trashed', compact('categories'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.expense-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category = ExpenseCategory::create([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.expense-categories.index')->with('success', 'Category created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        $category = ExpenseCategory::find($id);
        return view('admin.expense-categories.edit', compact('category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $category = ExpenseCategory::find($id);
        $request->validate([
            'name' => 'required',
        ]);
        $category->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.expense-categories.index')->with('success', 'Category Updated Successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $category = ExpenseCategory::find($id);
        $category->delete();
        return redirect()->route('admin.expense-categories.index')->with('success', 'Category Deleted Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $category = ExpenseCategory::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(ExpenseCategory::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.expense-categories.show', compact('category', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $category = ExpenseCategory::withTrashed()->find($id);
        $category->restore();
        return redirect()->route('admin.expense-categories.index')->with('success Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $category = ExpenseCategory::withTrashed()->find($id);
        $category->forceDelete();
        return redirect()->route('admin.expense-categories.trashed')->with('success Permanently Deleted');
    }
}
