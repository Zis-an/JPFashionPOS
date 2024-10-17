<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkModelStatus:App\Models\Deposit,deposit')
            ->only(['edit', 'update', 'updateStatus', 'destroy', 'restore', 'force_delete']);
    }

    public function index(): View|Factory|Application
    {
        $deposits = Deposit::orderBy('id', 'DESC')->get();
        return view('admin.deposits.index', compact('deposits'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $deposits = Deposit::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.deposits.trashed', compact('deposits'));
    }

    public function create(): View|Factory|Application
    {
        $accounts = Account::all();
        return view('admin.deposits.create', compact('accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'account_id' => 'required',
            'amount' => 'required',
            'notes' => 'nullable',
            'image' => 'nullable',
        ]);
        $image = '';
        if ($request->hasFile('photo')) {
            $image = $request->file('photo')->store('deposit-photo');
        }
        Deposit::create([
            'account_id' => $request->account_id,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'image' => $image ? 'uploads/' . $image : null
        ]);
        return redirect()->route('admin.deposits.index')->with('success', 'Deposit created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $deposit = Deposit::find($id);
        $accounts = Account::all();
        return view('admin.deposits.edit', compact('deposit', 'accounts'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $deposit = Deposit::find($id);
        $request->validate([
            'account_id' => 'required',
            'amount' => 'required',
            'notes' => 'nullable',
            'image' => 'nullable',
            'status' => 'required'
        ]);
        $image = $deposit->image ?? null;
        if ($request->hasFile('photo')) {
            if($deposit->image) {
                $prev_image = $deposit->image;
                if (file_exists($prev_image)) {
                    unlink($prev_image);
                }
            }
            $image = 'uploads/' . $request->file('photo')->store('deposit-photo');
        }
        $accountId = $request->account_id ?? $deposit->account_id;
        $deposit->update([
            'account_id' => $accountId,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'image' =>  $image,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.deposits.index')->with('success', 'Deposit updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $deposit = Deposit::find($id);
        if ($deposit->image) {
            $previousImages = json_decode($deposit->images, true);
            if ($previousImages) {
                foreach ($previousImages as $previousImage) {
                    $imagePath = public_path('uploads/' . $previousImage);
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image file
                    }
                }
            }
        }
        $deposit->delete();
        return redirect()->route('admin.deposits.index')->with('success', 'Deposit deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $deposit = Deposit::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Deposit::class, $id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('admin.deposits.show', compact('deposit', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $deposit = Deposit::withTrashed()->find($id);
        $deposit->restore();
        return redirect()->back()->with('success', 'Deposit restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $deposit = Deposit::withTrashed()->find($id);
        if ($deposit->image) {
            $imagePath = public_path($deposit->images);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $deposit->forceDelete();
        return redirect()->back()->with('success', 'Deposit Permanently Deleted');
    }

    public function updateStatus($id, $status): RedirectResponse
    {
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return redirect()->route('admin.deposits.index')->with('error', 'Invalid status.');
        }
        $deposit = Deposit::find($id);
        if (!$deposit) {
            return redirect()->back()->with('error', 'Deposit not found.');
        }
        $deposit->status = $status;
        $deposit->update();
        return redirect()->back()->with('success', 'Deposit status updated successfully.');
    }
}
