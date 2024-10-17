<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Showroom;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ShowroomController extends Controller
{
    public function index(): View|Factory|Application
    {
        $showrooms = Showroom::orderBy('id', 'DESC')->get();
        return view('admin.showrooms.index', compact('showrooms'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.showrooms.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:showrooms,name',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'nullable|string',
        ]);
        Showroom::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status ?? 'active',
        ]);
        return redirect()->route('admin.showrooms.index')->with('success', 'Showroom created successfully');
    }

    public function edit($id): View|Factory|Application
    {
        $showroom = Showroom::find($id);
        return view('admin.showrooms.edit', compact('showroom'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $showroom = Showroom::find($id);
        $request->validate([
            'name' => 'required|unique:showrooms,name,'.$showroom->id,
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'status' => 'nullable|string',
        ]);
        $showroom->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status ?? 'active',
        ]);
        return redirect()->route('admin.showrooms.index')->with('success', 'Showroom updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $showroom = Showroom::find($id);
        $showroom->delete();
        return redirect()->route('admin.showrooms.index')->with('success', 'Showroom deleted successfully');
    }

    public function show($id): View|Factory|Application
    {
        $showroom = Showroom::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Showroom::class, $id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('admin.showrooms.show', compact('showroom', 'admins', 'activities'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $showrooms = Showroom::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.showrooms.trashed', compact('showrooms'));
    }

    public function restore($id): RedirectResponse
    {
        $showroom = Showroom::withTrashed()->find($id);
        $showroom->restore();
        return redirect()->route('admin.showrooms.index')->with('success', 'Showroom restored successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $showroom = Showroom::withTrashed()->find($id);
        $showroom->forceDelete();
        return redirect()->route('admin.showrooms.trashed')->with('success', 'Showroom permanently deleted');
    }
}
