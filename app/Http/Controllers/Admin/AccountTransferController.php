<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\AccountTransfer;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class AccountTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkModelStatus:App\Models\AccountTransfer,account_transfer')
            ->only(['edit', 'update', 'updateStatus', 'destroy', 'restore', 'force_delete']);
    }

    public function index(): View|Factory|Application
    {
        $transfers = AccountTransfer::orderBy('id', 'DESC')->get();
        return view('admin.account_transfers.index', compact('transfers'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $transfers = AccountTransfer::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.account_transfers.trashed', compact('transfers'));
    }

    public function create(): View|Factory|Application
    {
        $accounts = Account::all();
        return view('admin.account_transfers.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_account_id' => 'required',
            'to_account_id' => 'required',
            'amount' => 'required',
            'notes' => 'nullable',
            'image' => 'nullable',
        ]);
        $image = '';
        if ($request->hasFile('photo')) {
            $image = $request->file('photo')->store('transfer-photo');
        }
        $fromAccountInfo = Account::findOrFail($request->from_account_id);
        if ($fromAccountInfo->balance < $request->amount) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Insufficient Balance'], 400);
            }
            return redirect()->back()->with('error', 'Insufficient Balance');
        }
        AccountTransfer::create([
            'from_account_id' => $request->from_account_id,
            'to_account_id' => $request->to_account_id,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'image' => $image ? 'uploads/' . $image : null
        ]);
        return redirect()->route('admin.account-transfers.index')->with('success', 'Transfer created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $transfer = AccountTransfer::find($id);
        $accounts = Account::all();
        return view('admin.account_transfers.edit', compact('transfer', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $transfer = AccountTransfer::find($id);
        $request->validate([
            'from_account_id' => 'required',
            'to_account_id' => 'required',
            'amount' => 'required',
            'notes' => 'nullable',
            'image' => 'nullable',
            'status' => 'required'
        ]);
        $fromAccountInfo = Account::findOrFail($request->from_account_id);
        if ($fromAccountInfo->balance < $request->amount) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Insufficient Balance'], 400);
            }
            return redirect()->back()->with('error', 'Insufficient Balance');
        }
        $image = $transfer->image ?? null;
        if ($request->hasFile('photo')) {
            if($transfer->image) {
                $prev_image = $transfer->image;
                if (file_exists($prev_image)) {
                    unlink($prev_image);
                }
            }
            $image = 'uploads/' . $request->file('photo')->store('transfer-photo');
        }
        $transfer->update([
            'from_account_id' => $request->from_account_id,
            'to_account_id' => $request->to_account_id,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'image' =>  $image,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.account-transfers.index')->with('success', 'Transfer updated successfully.');
    }


    public function destroy($id): RedirectResponse
    {
        $transfer = AccountTransfer::find($id);
        if ($transfer->image) {
            $previousImages = json_decode($transfer->images, true);
            if ($previousImages) {
                foreach ($previousImages as $previousImage) {
                    $imagePath = public_path('uploads/' . $previousImage);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image file
                    }
                }
            }
        }
        $transfer->delete();
        return redirect()->route('admin.account-transfers.index')->with('success', 'Transfer deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $transfer = AccountTransfer::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(AccountTransfer::class, $id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('admin.account_transfers.show', compact('transfer', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $transfer = AccountTransfer::withTrashed()->find($id);
        $transfer->restore();
        return redirect()->back()->with('success', 'Transfer restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $transfer = AccountTransfer::withTrashed()->find($id);
        if ($transfer->image) {
            $imagePath = public_path($transfer->images);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $transfer->forceDelete();
        return redirect()->back()->with('success', 'Transfer Permanently Deleted');
    }

    public function updateStatus($id, $status): RedirectResponse
    {
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return redirect()->route('admin.account-transfers.index')->with('error', 'Invalid status.');
        }
        $transfer = AccountTransfer::find($id);
        if (!$transfer) {
            return redirect()->back()->with('error', 'Transfer not found.');
        }
        $transfer->status = $status;
        $transfer->update();
        return redirect()->back()->with('success', 'Transfer status updated successfully.');
    }
}
