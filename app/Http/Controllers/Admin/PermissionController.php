<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;



class PermissionController extends Controller
{
    public function index(): View|Factory|Application
    {
        $permissions =  Permission::orderBy('id','DESC')->get();
        return view('admin.permissions.index',compact('permissions'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'=>'required|unique:permissions|min:3',
            'guard_name'=>'required|min:3',
            'group_name'=>'required|min:3',
        ]);
        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'group_name' => $request->group_name,
        ]);
        toastr()->success($request->name. __(' Created Successfully'));
        return redirect()->route('admin.permissions.index');
    }

    public function destroy($id): RedirectResponse
    {
        Permission::find($id)->delete();
        toastr()->error( __('Something Went Wrong'));
        return redirect()->route('admin.permissions.index');
    }

    public function edit($id): View|Factory|Application
    {
        $permission = Permission::find($id);
        return view('admin.permissions.edit',compact('permission'));
    }

    public function update(Request $request,$id): RedirectResponse
    {
        $request->validate([
            'name'=>'required|unique:permissions,name,'.$id.'|min:3',
            'guard_name'=>'required|min:3',
            'group_name'=>'required|min:3',
        ]);
        $permission = Permission::where('id',$id)->first();
        $permission->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'group_name' => $request->group_name,
        ]);
        toastr()->success($request->name. __(' Updated Successfully'));
        return redirect()->back();
    }

    public function show($id): View|Factory|Application
    {
        $permission = Permission::find($id);
        return view('admin.permissions.show',compact('permission'));
    }
}
