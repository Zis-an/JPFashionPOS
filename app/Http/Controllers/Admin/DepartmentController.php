<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    public function index(): View|Factory|Application
    {
        $departments = Department::orderBy('id', 'DESC')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $departments = Department::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.departments.trashed', compact('departments'));
    }

    public function create(): View|Factory|Application
    {
        $categories = Department::orderBy('id', 'DESC')->get();
        return view('admin.departments.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required']);
        $department = Department::create(['name' => $request->name]);
        return redirect()->route('admin.departments.index')->with('success','Department created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $department = Department::find($id);
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $department = Department::find($id);
        $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
        $department->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.departments.index')->with('success','Department updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $department = Department::find($id);
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success','Department deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $department = Department::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Department::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.departments.show', compact('department', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $department = Department::withTrashed()->find($id);
        $department->restore();
        return redirect()->route('admin.departments.index')->with('success','Department restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $department = Department::withTrashed()->find($id);
        $department->forceDelete();
        return redirect()->route('admin.departments.trashed')->with('success','Department Permanently Deleted');
    }
}
