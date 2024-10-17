<?php

namespace App\Models;

use App\Traits\HandlesAccountTransactions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AdminLog;

class Expense extends Model
{
    use HandlesAccountTransactions, AdminLog, SoftDeletes,HasFactory;

    public function getTransactionType(): string
    {
        // Check the status of the expense to determine the transaction type
        if ($this->status === 'approved') {
            return 'out'; // Money goes out for approved expenses
        } elseif ($this->status === 'pending' || $this->status === 'rejected') {
            return 'in'; // Money comes in if the expense is pending or rejected
        }
        // You can add additional conditions as needed
        return 'out'; // Default to 'out' if no conditions are met
    }

    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id');
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class,'account_id');
    }
    public function accountTransaction(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AccountTransaction::class, 'model_id')
            ->where('model', '=', get_class($this)); // Ensures model matches the class
    }
}
