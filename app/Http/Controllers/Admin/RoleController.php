<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{

    public function index(): View|Factory|Application
    {
        $user=Auth::user();
        if($user->hasAnyRole([ 'super_admin'])){
            $roles =  Role::orderBy('id','DESC')->get();
        } else {
            $roles = Role::where('name','!=','super_admin')->get();
        }
        return view('admin.roles.index',compact('roles'));
    }

    public function show($id): View|Factory|Application
    {
        $role =  Role::where('id',$id)->first();
        $permissions = Permission::orderBy('id','DESC')->get();
        $all_permissions = Permission::orderBy('id','DESC')->get();
        $permissions_groups = Permission::select('group_name')->groupBy('group_name')->get();
        return view('admin.roles.show',compact(['role','permissions','permissions_groups','all_permissions']));
    }

    public function create(): View|Factory|Application
    {
        $permissions = Permission::orderBy('id','DESC')->get();
        $permissions_groups = Permission::select('group_name')->groupBy('group_name')->get();
        return view('admin.roles.create',compact(['permissions','permissions_groups']));
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'=>'required|unique:roles|min:3',
            'guard_name'=>'required|min:3',
        ]);
        $role =  Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);
        $role->syncPermissions($request->permissions);
        toastr()->success($request->name. ' role created successfully.');
        return redirect()->route('admin.roles.index');
    }

    public function edit($id): View|Factory|Application
    {
        $role =  Role::where('id',$id)->first();
        $permissions = Permission::where('guard_name',$role->guard_name)->get();
        $all_permissions = Permission::where('guard_name',$role->guard_name)->get();
        $permissions_groups = Permission::select('group_name')->groupBy('group_name')->where('guard_name',$role->guard_name)->get();
        return view('admin.roles.edit',compact(['role','permissions','permissions_groups','all_permissions']));
    }

    public function update(Request $request,$id): RedirectResponse
    {
        $request->validate([
            'name'=>'required|min:3',
            'guard_name'=>'required|min:3',
        ]);
        $role = Role::where('id',$id)->first();
        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);
        $role->syncPermissions($request->permissions);
        toastr()->success($request->name . ' Updated Successfully.');
        return redirect()->back();
    }

    public function destroy($id): RedirectResponse
    {
        Role::find($id)->delete();
        toastr()->success( ' Role deleted successfully.');
        return redirect()->route('admin.roles.index');
    }
}
