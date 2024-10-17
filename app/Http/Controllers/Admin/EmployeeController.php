<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use \Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    public function index(): View|Factory|Application
    {
        $employees = Employee::orderBy('id', 'DESC')->with('department')->get();
        return view('admin.employees.index', compact('employees'));
    }

    public function create(): View|Factory|Application
    {
        $departments = Department::all();
        return view('admin.employees.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|unique:employees',
            'phone' => 'nullable|unique:employees',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'hire_date' => 'required|date',
            'position' => 'required|string',
            'department_id' => 'required',
            'education_level' => 'nullable|string',
            'ed_certificate' => 'nullable',
            'nid' => 'required|unique:employees',
            'service_days' => 'required',
            'gender' => 'nullable|string|in:male,female,other',
            'salary' => 'required',
            'status' => 'nullable|string|in:active,deactive,terminated',
        ]);

        $certificatePaths = [];

        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $photo) {
                $certificatePaths[] = 'uploads/' . $photo->store('employees-education-certificate-photos');
            }
        }

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'hire_date' => $request->hire_date,
            'position' => $request->position,
            'department_id' => $request->department_id,
            'education_level' => $request->education_level,
            'ed_certificate' => json_encode($certificatePaths),
            'nid' => $request->nid,
            'service_days' => $request->service_days,
            'gender' => $request->gender,
            'salary' => $request->salary,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully');
    }


    public function edit($id): View|Factory|Application
    {
        $employee = Employee::find($id);
        $departments = Department::all();
        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $employee = Employee::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'hire_date' => 'required|date',
            'position' => 'required|string',
            'department_id' => 'required',
            'education_level' => 'nullable|string',
            'ed_certificate' => 'nullable',
            'nid' => 'required',
            'service_days' => 'required',
            'gender' => 'nullable|string|in:male,female,other',
            'salary' => 'required',
            'status' => 'required',
        ]);
        $certificatePaths = json_decode($employee->ed_certificate, true) ?? [];
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $photo) {
                $certificatePaths[] = 'uploads/' . $photo->store('employees-education-certificate-photos');
            }
        }
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'hire_date' => $request->hire_date,
            'position' => $request->position,
            'department_id' => $request->department_id,
            'education_level' => $request->education_level,
            'ed_certificate' => json_encode($certificatePaths),
            'nid' => $request->nid,
            'service_days' => $request->service_days,
            'gender' => $request->gender,
            'salary' => $request->salary,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully');
    }



    public function destroy($id): RedirectResponse
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully');
    }

    public function show($id): View|Factory|Application
    {
        $employee = Employee::with('department')->findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Employee::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.employees.show', compact('employee', 'admins', 'activities'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $employees = Employee::onlyTrashed()->with('department')->orderBy('id', 'DESC')->get();
        return view('admin.employees.trashed', compact('employees'));
    }

    public function restore($id): RedirectResponse
    {
        $employee = Employee::withTrashed()->find($id);
        $employee->restore();
        return redirect()->route('admin.employees.index')->with('success', 'Employee restored successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $employee = Employee::withTrashed()->find($id);
        $employee->forceDelete();
        return redirect()->route('admin.employees.trashed')->with('success', 'Employee permanently deleted');
    }

    public function delete_certificate(Request $request, $id, $key): JsonResponse
    {
        $employee = Employee::findOrFail($id);
        $certificatePaths = json_decode($employee->ed_certificate, true);
        if (isset($certificatePaths[$key])) {
            $imagePath = public_path($certificatePaths[$key]);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Remove the image path from the array
            unset($certificatePaths[$key]);
            // Update the employee's certificate paths
            $employee->ed_certificate = json_encode(array_values($certificatePaths));
            $employee->save();
            return response()->json(['message' => 'Image deleted successfully']);
        }
        return response()->json(['message' => 'Image not found'], 404);
    }
}
