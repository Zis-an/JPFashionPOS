<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\AccountTransfer;
use App\Models\Admin;
use App\Models\AdminActivity;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index(): View|Factory|Application
    {
        $accounts = Account::orderBy('id', 'DESC')->get();
        return view('admin.accounts.index', compact('accounts'));
    }

    public function create(): View|Factory|Application
    {
        $admins = Admin::all();
        return view('admin.accounts.create', compact('admins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:accounts',
            'type' => 'required',
            'admin_id' => 'required|integer',
            'status' => 'required',
        ]);
        $account = Account::create([
            'name' => $request->name,
            'type' => $request->type,
            'admin_id' => $request->admin_id,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.accounts.index')->with('success', 'Account has been created');
    }

    public function edit($id): View|Factory|Application
    {
        $account = Account::find($id);
        $admins = Admin::all();
        return view('admin.accounts.edit', compact(['account', 'admins']));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $account = Account::find($id);
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'admin_id' => 'required',
            'status' => 'required',
        ]);
        $account->update([
            'name' => $request->name,
            'type' => $request->type,
            'admin_id' => $request->admin_id,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.accounts.index')->with('success', 'Account has been updated');
    }

    public function destroy($id): RedirectResponse
    {
        $account = Account::find($id);
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account has been deleted');
    }

    public function trashed_list(): View|Factory|Application
    {
        $accounts = Account::onlyTrashed()->orderBy('id', 'DESC')->get();
        return view('admin.accounts.trashed', compact('accounts'));
    }

    public function show($id): View|Factory|Application
    {
        $account = Account::findOrFail($id);
        $admins = Admin::all();
        $activities = AdminActivity::getActivities(Account::class, $id)->orderBy('created_at', 'desc')->take(10)->get();
        $totalDebit = AccountTransaction::where('account_id', $id)
            ->where('transaction_type', 'out')
            ->sum('amount');
        $totalCredit = AccountTransaction::where('account_id', $id)
            ->where('transaction_type', 'in')
            ->sum('amount');
        $data = [
            'labels' => ['Debit', 'Credit'],
            'data' => [$totalDebit, $totalCredit],
        ];
        // Prepare arrays for monthly data
        $months = [];
        $monthlyDebit = [];
        $monthlyCredit = [];

        for ($i = 1; $i <= 12; $i++) {
            // Format month name
            $months[] = date('F', mktime(0, 0, 0, $i, 1));

            // Calculate total debit for the month
            $monthlyDebit[] = AccountTransaction::where('account_id', $id)
                ->where('transaction_type', 'out')
                ->whereMonth('created_at', $i)
                ->sum('amount');

            // Calculate total credit for the month
            $monthlyCredit[] = AccountTransaction::where('account_id', $id)
                ->where('transaction_type', 'in')
                ->whereMonth('created_at', $i)
                ->sum('amount');
        }
        $lineData = $this->getMonthlyModelWiseTransactions($id);
        $months = $lineData['months'];
        $monthlyData = $lineData['monthlyData'];

        $datasets = []; // To hold datasets for each model

        // Create datasets for each model
        foreach ($monthlyData as $model => $transactions) {
            $modelName = class_basename($model);
            $colors = generateColor($modelName);

            // Check if there's any debit transaction for the model
            if (array_sum($transactions['debit']) > 0) {
                // Prepare debit dataset for the model
                $datasets[] = [
                    'label' => $modelName . ' Debit',
                    'data' => array_values($transactions['debit']), // Get debit amounts for each month
                    'backgroundColor' => $colors['backgroundColor'], // Customize as needed
                    'borderColor' => $colors['borderColor'], // Customize as needed
                    'borderWidth' => 1,
                    'fill' => false,
                ];
            }

            // Check if there's any credit transaction for the model
            if (array_sum($transactions['credit']) > 0) {
                // Prepare credit dataset for the model
                $datasets[] = [
                    'label' => $modelName . ' Credit',
                    'data' => array_values($transactions['credit']), // Get credit amounts for each month
                    'backgroundColor' => $colors['backgroundColor'], // Customize as needed
                    'borderColor' => $colors['borderColor'], // Customize as needed
                    'borderWidth' => 1,
                    'fill' => false,
                ];
            }
        }

        $lineChartData = [
            'labels' => $months,
            'datasets' => $datasets,
        ];

        $transactionInfo = DB::table('account_transactions')->where('account_id', $account->id)->get();
        $pendingTransactions = AccountTransfer::where('from_account_id', $id)->where('status', '=', 'pending')->get();
        $accounts = Account::all();
        return view('admin.accounts.show',
            compact('account',
                'admins',
                'activities',
                'data',
                'lineChartData',
                'transactionInfo',
                'accounts',
                'pendingTransactions'
            ));
    }

    public function restore($id): RedirectResponse
    {
        $account = Account::withTrashed()->find($id);
        $account->restore();
        return redirect()->route('admin.accounts.index')->with('success', 'Account has been restored');
    }

    public function force_delete($id): RedirectResponse
    {
        $account = Account::withTrashed()->find($id);
        $account->forceDelete();
        return redirect()->route('admin.accounts.trashed')->with('success', 'Account has been deleted');
    }

    public function getMonthlyModelWiseTransactions($accountId)
    {
        // Prepare arrays for month names and model transactions
        $months = [];
        $monthlyData = []; // To hold total amounts grouped by model

        // Get transactions grouped by month and model
        for ($i = 1; $i <= 12; $i++) {
            // Format month name
            $months[] = date('F', mktime(0, 0, 0, $i, 1));

            // Retrieve monthly transactions for the specific account, grouped by model and transaction type
            $monthlyTransactions = AccountTransaction::select(DB::raw('model, transaction_type, SUM(amount) as total_amount'))
                ->where('account_id', $accountId)
                ->whereMonth('created_at', $i)
                ->groupBy('model', 'transaction_type')
                ->get();

            // Store the total amounts in the array
            foreach ($monthlyTransactions as $transaction) {
                // Initialize model data if it doesn't exist
                if (!isset($monthlyData[$transaction->model])) {
                    $monthlyData[$transaction->model] = [
                        'debit' => array_fill(1, 12, 0),  // Initialize debit amounts
                        'credit' => array_fill(1, 12, 0), // Initialize credit amounts
                    ];
                }

                // Assign total amount to the corresponding model and type
                if ($transaction->transaction_type === 'out') {
                    $monthlyData[$transaction->model]['debit'][$i] = $transaction->total_amount; // For 'out', it's debit
                } else {
                    $monthlyData[$transaction->model]['credit'][$i] = $transaction->total_amount; // For 'in', it's credit
                }
            }
        }

        return [
            'months' => $months,
            'monthlyData' => $monthlyData,
        ];
    }

}
