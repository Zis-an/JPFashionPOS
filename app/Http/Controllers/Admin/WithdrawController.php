<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Withdraw;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkModelStatus:App\Models\Withdraw,withdraw')
            ->only(['edit', 'update', 'updateStatus', 'destroy', 'restore', 'force_delete']);
    }

    public function index(): View|Factory|Application
    {
        $withdraws = Withdraw::orderBy('id', 'DESC')->get();
        return view('admin.withdraws.index', compact('withdraws'));
    }

    public function trashed_list(): View|Factory|Application
    {
        $withdraws = Withdraw::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.withdraws.trashed', compact('withdraws'));
    }

    public function create(): View|Factory|Application
    {
        $accounts = Account::all();
        return view('admin.withdraws.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required',
            'amount' => 'required',
            'notes' => 'nullable',
            'image' => 'nullable',
        ]);
        $image = '';
        if ($request->hasFile('photo')) {
            $image = $request->file('photo')->store('withdraw-photo');
        }
        $account = Account::findOrFail($request->account_id);
        if ($account->balance < $request->amount) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Insufficient Balance'], 400);
            }
            return redirect()->back()->with('error', 'Insufficient Balance');
        }
        Withdraw::create([
            'account_id' => $request->account_id,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'image' => $image ? 'uploads/' . $image : null
        ]);
        return redirect()->route('admin.withdraws.index')->with('success','Withdraw created successfully.');
    }

    public function edit($id): View|Factory|Application
    {
        $withdraw = Withdraw::find($id);
        $accounts = Account::all();
        return view('admin.withdraws.edit', compact('withdraw', 'accounts'));
    }

    public function update(Request $request, $id)
    {
        $withdraw = Withdraw::find($id);
        $request->validate([
            'account_id' => 'required',
            'amount' => 'required',
            'notes' => 'nullable',
            'image' => 'nullable',
            'status' => 'required',
        ]);
        $image = $withdraw->image ?? null;
        if ($request->hasFile('photo')) {
            if($withdraw->image) {
                $prev_image = $withdraw->image;
                if (file_exists($prev_image)) {
                    unlink($prev_image);
                }
            }
            $image = 'uploads/' . $request->file('photo')->store('withdraw-photo');
        }
        $account = Account::findOrFail($request->account_id);
        if ($account->balance < $request->amount) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Insufficient Balance'], 400);
            }
            return redirect()->back()->with('error', 'Insufficient Balance');
        }
        $accountId = $request->account_id ?? $withdraw->account_id;
        $withdraw->update([
            'account_id' => $accountId,
            'amount' => $request->amount,
            'status' => $request->status,
            'notes' => $request->notes,
            'image' =>  $image,
        ]);
        return redirect()->route('admin.withdraws.index')->with('success','Withdraw updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $withdraw = Withdraw::find($id);
        if ($withdraw->image) {
            $previousImages = json_decode($withdraw->image, true);
            if ($previousImages) {
                foreach ($previousImages as $previousImage) {
                    $imagePath = public_path('uploads/' . $previousImage);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
        }
        $withdraw->delete();
        return redirect()->route('admin.withdraws.index')->with('success','Withdraw deleted successfully.');
    }

    public function show($id): View|Factory|Application
    {
        $withdraw = Withdraw::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Withdraw::class, $id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('admin.withdraws.show', compact('withdraw', 'admins', 'activities'));
    }

    public function restore($id): RedirectResponse
    {
        $withdraw = Withdraw::withTrashed()->find($id);
        $withdraw->restore();
        return redirect()->back()->with('success','Withdraw restored successfully.');
    }

    public function force_delete($id): RedirectResponse
    {
        $withdraw = Withdraw::withTrashed()->find($id);
        if ($withdraw->image) {
            $imagePath = public_path($withdraw->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $withdraw->forceDelete();
        return redirect()->back()->with('success','Withdraw Permanently Deleted');
    }

    public function updateStatus($id, $status): RedirectResponse
    {
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return redirect()->route('admin.withdraws.index')->with('error', 'Invalid status.');
        }
        $withdraw = Withdraw::find($id);
        if (!$withdraw) {
            return redirect()->back()->with('error','Withdraw not found.');
        }
        $withdraw->status = $status;
        $withdraw->update();
        return redirect()->back()->with('success','Withdraw status updated successfully.');
    }
}
