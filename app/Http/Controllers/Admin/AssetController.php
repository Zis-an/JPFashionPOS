<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkModelStatus:App\Models\Asset,asset')->only(['edit', 'update', 'updateStatus', 'destroy', 'restore', 'force_delete']);
    }

    public function index(): View|Factory|Application
    {
        $assets = Asset::orderBy('id', 'DESC')->get();
        return view('admin.assets.index', compact('assets'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $assets = Asset::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.assets.trashed', compact('assets'));
    }

    public function create(): View|Factory|Application
    {
        $categories = AssetCategory::orderBy('id', 'DESC')->get();
        $accounts = Account::all();
        return view('admin.assets.create', compact('categories', 'accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'amount' => 'required',
            'account_id' => 'required',
            'details' => 'nullable',
            'images' => 'nullable',
        ]);
        $image = '';
        if ($request->hasFile('photo')) {
            $image = $request->file('photo')->store('asset-photo');
        }
        Asset::create([
            'name' => $request->name,
            'asset_category_id' => $request->category_id,
            'amount' => $request->amount,
            'account_id' => $request->account_id,
            'details' => $request->details,
            'images' => $image ? 'uploads/' . $image : null
        ]);
        return redirect()->route('admin.assets.index')->with('success', 'Asset created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $asset = Asset::find($id);
        $categories = AssetCategory::orderBy('id', 'DESC')->get();
        $accounts = Account::all();
        return view('admin.assets.edit', compact('asset', 'categories', 'accounts'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $asset = Asset::find($id);
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'account_id' => 'required',
            'details' => 'nullable',
            'status' => 'required',
            'images' => 'nullable',
        ]);
        $image = $asset->images ?? null;
        if ($request->hasFile('photo')) {
            // Delete previous image
            if($asset->images) {
                $prev_image = $asset->images;
                if (file_exists($prev_image)) {
                    unlink($prev_image);
                }
            }
            $image = 'uploads/' . $request->file('photo')->store('asset-photo');
        }

        $accountId = $request->account_id ?? $asset->account_id;

        $asset->update([
            'name' => $request->name,
            'asset_category_id' => $request->category_id,
            'account_id' => $accountId,
            'amount' => $request->amount,
            'status' => $request->status,
            'details' => $request->details,
            'images' =>  $image,
        ]);

        return redirect()->route('admin.assets.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $asset = Asset::find($id);
        if ($asset->images) {
            $previousImages = json_decode($asset->images, true);
            if ($previousImages) {
                foreach ($previousImages as $previousImage) {
                    $imagePath = public_path('uploads/' . $previousImage);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image file
                    }
                }
            }
        }
        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', 'Asset deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $asset = Asset::findOrFail($id);
        $admins = Admin::all();
        $categories = AssetCategory::all();
        $activities = AdminActivity::getActivities(Asset::class, $id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('admin.assets.show', compact('asset', 'admins', 'activities', 'categories'));
    }

    public function restore($id): RedirectResponse
    {
        $asset = Asset::withTrashed()->find($id);
        $asset->restore();
        toastr()->success($asset->name . ' Restored Successfully');
        return redirect()->back()->with('success', 'Asset restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $asset = Asset::withTrashed()->find($id);

        if ($asset->images) {
            $imagePath = public_path($asset->images);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $asset->forceDelete();
        return redirect()->back()->with('success', 'Asset Permanently Deleted');
    }

    public function updateStatus($id, $status): RedirectResponse
    {
        // Validate the status
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return redirect()->route('admin.assets.index')->with('error', 'Invalid status.');
        }
        // Find the asset
        $asset = Asset::find($id);
        if (!$asset) {
            return redirect()->back()->with('error', 'Asset not found.');
        }
        // Update the asset status
        $asset->status = $status;
        $asset->update();
        return redirect()->back()->with('success', 'Asset status updated successfully.');
    }
}
