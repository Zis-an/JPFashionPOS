<?php

namespace App\Models;

use App\Traits\AdminLog;
use App\Traits\HandlesAccountTransactions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use HandlesAccountTransactions, AdminLog, SoftDeletes,HasFactory;
    public function getTransactionType(): string
    {
        if ($this->status === 'approved') {
            return 'out';
        } elseif ($this->status === 'pending' || $this->status === 'rejected') {
            return 'in';
        }
        return 'out';
    }
    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class);
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
