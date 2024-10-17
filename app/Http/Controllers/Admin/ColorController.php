<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ColorController extends Controller
{
    public function index(): View|Factory|Application
    {
        $colors = Color::orderBy('id', 'DESC')->get();
        return view('admin.colors.index', compact('colors'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $colors = Color::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.colors.trashed', compact('colors'));
    }

    public function create(): View|Factory|Application
    {
        return view('admin.colors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'color_code' => 'required',
            'name' => 'required',
        ]);

        $color = Color::create([
            'color_code' => $request->color_code,
            'color_name' => $request->name
        ]);
        return redirect()->route('admin.colors.index')->with('success', 'Color created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $color = Color::find($id);
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $color = Color::find($id);
        $request->validate([
            'color_code' => 'required',
            'name' => 'required',
        ]);
        $color->update([
            'color_code' => $request->color_code,
            'color_name' => $request->name,
        ]);
        return redirect()->route('admin.colors.index')->with('success', 'Color updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $color = Color::find($id);
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $color = color::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Color::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.colors.show', compact('color', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $color = Color::withTrashed()->find($id);
        $color->restore();
        return redirect()->route('admin.colors.index')->with('success', 'Color restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $color = Color::withTrashed()->find($id);
        $color->forceDelete();
        return redirect()->route('admin.colors.trashed')->with('success', 'Color Permanently Deleted');
    }
}
