<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Admin;
use App\Models\AdminActivity;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkModelStatus:App\Models\Expense,expense')->only(['edit', 'update', 'updateStatus', 'destroy', 'restore', 'force_delete']);
    }

    public function index(): View|Factory|Application
    {
        $expenses = Expense::orderBy('id', 'DESC')->latest()->get();
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create(): View|Factory|Application
    {
        $categories = ExpenseCategory::orderBy('id', 'DESC')->get();
        $accounts = Account::where('status', '=', 'active')->orderBy('id', 'DESC')->get();
        return view('admin.expenses.create', compact('categories', 'accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'account_id' => 'required',
            'amount' => 'required',
            'details' => 'required',
            'images' => 'nullable',
        ]);
        $image = '';
        if ($request->hasFile('photo')) {
            $image = $request->file('photo')->store('expense-photo');
        }
        $expense = Expense::create([
            'title' => $request->title,
            'expense_category_id' => $request->category_id,
            'account_id' => $request->account_id,
            'amount' => $request->amount,
            'details' => $request->details,
            'images' => $image ? 'uploads/' . $image : null
        ]);
        return redirect()->route('admin.expenses.index')->with('success', 'Expense Created Successfully');
    }

    public function show($id): View|Factory|Application
    {
        $expense = Expense::findOrFail($id);
        $categories = ExpenseCategory::all();
        $accounts = Account::all();
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Expense::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.expenses.show', compact('expense', 'categories', 'accounts', 'admins', 'activities'));
    }

    public function edit($id): View|Factory|Application
    {
        $expense = Expense::find($id);
        $categories = ExpenseCategory::orderBy('id', 'DESC')->get();
        $accounts = Account::orderBy('id', 'DESC')->get();
        return view('admin.expenses.edit', compact('expense', 'categories', 'accounts'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $expense = Expense::find($id);
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'account_id' => 'required',
            'details' => 'nullable',
            'status' => 'required',
            'images' => 'nullable',
        ]);
        $image = $expense->images ?? null;
        if ($request->hasFile('photo')) {
            // Delete previous image
            if($expense->images) {
                $prev_image = $expense->images;
                if (file_exists($prev_image)) {
                    unlink($prev_image);
                }
            }
            $image = 'uploads/' . $request->file('photo')->store('expense-photo');
        }

        $accountId = $request->account_id ?? $expense->account_id;

        $expense->update([
            'title' => $request->title,
            'expense_category_id' => $request->category_id,
            'account_id' => $accountId,
            'amount' => $request->amount,
            'status' => $request->status,
            'details' => $request->details,
            'images' => 'uploads/' . $image,
        ]);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense Updated Successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $expense = Expense::find($id);
        if ($expense->images) {
            $previousImages = json_decode($expense->images, true);
            if ($previousImages) {
                foreach ($previousImages as $previousImage) {
                    $imagePath = public_path('uploads/' . $previousImage);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
        }
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense Deleted Successfully');
    }

    public function trashed_list(): View|Factory|Application
    {
        $expenses = Expense::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.expenses.trashed', compact('expenses'));
    }

    public function restore($id): RedirectResponse
    {
        $expense = Expense::withTrashed()->find($id);
        $expense->restore();
        return redirect()->back()-with('success', 'Expense Restored Successfully');
    }

    public function force_delete($id): RedirectResponse
    {
        $expense = Expense::withTrashed()->find($id);

        if ($expense->images) {
            $imagePath = public_path($expense->images);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $expense->forceDelete();
        return redirect()->back()->with('success','Expense Permanently Deleted');
    }

    public function updateStatus($id, $status): RedirectResponse
    {
        // Validate the status
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return redirect()->route('admin.expenses.index')->with('error', 'Invalid status.');
        }
        // Find the asset
        $asset = Expense::find($id);
        if (!$asset) {
            return redirect()->back()->with('error', 'Expense not found.');
        }
        // Update the asset status
        $asset->status = $status;
        $asset->update();
        return redirect()->back()->with('success', 'Expense status updated successfully.');
    }
}
