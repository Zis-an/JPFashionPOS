<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{

    public function index(): View|Factory|Application
    {
        $admins = Admin::orderBy('id','DESC')->get();
        return view('admin.admins.index',compact('admins'));
    }


    public function create(): View|Factory|Application
    {
        $roles = Role::where('name','!=','super_admin')->get();
        return view('admin.admins.create',compact(['roles']));
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed',
            'roles' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
        }
        $admin = Admin::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'status' =>$request->status,
            'photo' =>$imagePath,
            'password' => Hash::make($request->password) ,
        ]);
        $admin->syncRoles([$request->roles]);
        return redirect()->route('admin.admins.index')->with('success','Admin Created Successfully');
    }


    public function show($id): View|Factory|Application
    {
        $admin = Admin::find($id);
        return view('admin.admins.show',compact('admin'));
    }


    public function edit($id): View|Factory|Application
    {
        $admin = Admin::find($id);
        if(checkAdminRole($admin,'super_admin')){
            $roles = Role::all();
        } else {
            $roles = Role::where('name','!=','super_admin')->get();
        }
        return view('admin.admins.edit',compact(['admin','roles']));
    }


    public function update(Request $request, $id): RedirectResponse
    {
        $admin = Admin::find($id);
        $rules = [
            'name' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:admins,id,'.$id,
            'roles' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
        $request->validate($rules);
        // Update password if provided
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        // Handle file upload
        $imagePath = $admin->photo ?? null;
        if ($request->file('photo')) {
            $imagePath = $request->file('photo')->store('admin-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        // Update admin details
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->status = $request->status;
        $admin->photo = $imagePath;
        $admin->save();  // Use save() instead of update() to ensure the model is properly updated
        // Role management
        if (!$admin->hasAnyRole(['super_admin'])) {
            $admin->syncRoles($request->roles);
        } else {
            toastr()->error('Permission Denied');
        }
        return redirect()->route('admin.admins.index')->with('success', 'Admin Updated Successfully');
    }



    public function destroy($id): RedirectResponse
    {
        $admin = Admin::find($id);
        if(!$admin->hasAnyRole(['super-admin'])){
            $admin->delete();
        } else {
            toastr()->error('Permission Denied');
        }
        return redirect()->route('admin.admins.index')->with('success','Admin Deleted Successfully');
    }

    public function trashed_list(): View|Factory|Application
    {
        $admins = Admin::orderBy('id','DESC')->onlyTrashed()->get();
        return view('admin.admins.trashed',compact('admins'));
    }

    public function restore($id): RedirectResponse
    {
        $admin = Admin::withTrashed()->find($id);
        $admin->deleted_at = null;
        $admin->update();
        return redirect()->route('admin.admins.index')->with('success','Admin Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $admin = Admin::withTrashed()->find($id);
        $image = "uploads/".$admin->photo;
        if (file_exists($image)) {
            @unlink($image);
        }
        DB::table('accounts')->where('admin_id', $id)->update(['admin_id' => null]);
        DB::table('admin_activities')->where('admin_id', $id)->update(['admin_id' => null]);
        $admin->forceDelete();
        return redirect()->route('admin.admins.trashed')->with('success','Admin Permanent Deleted.');
    }

    public function profile(): View|Factory|Application
    {
        $admin = auth()->user();
        return view('admin.admins.profile',compact(['admin']));
    }

    public function profile_update(Request $request): RedirectResponse
    {
        $admin = auth()->user();
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'required|email|unique:admins,id,'.$admin->id,
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->password){
            $request->validate([
                'password' => 'confirmed',
            ]);
            $admin->password = Hash::make($request->password);
        }
        $imagePath = $admin->photo ?? null;
        if($request->file('photo')){
            $imagePath = $request->file('photo')->store('admin-photo');
            $old_image_path = "uploads/".$request->old_photo;
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->photo = $imagePath;
        $admin->status = $request->status;
        $admin->update();
        return redirect()->route('admin.profile')->with('success', 'Admin Profile Updated Successfully');
    }
}
