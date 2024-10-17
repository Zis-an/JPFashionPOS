<?php

namespace App\Models;

use App\Traits\HandlesAccountTransactions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AdminLog;

class Deposit extends Model
{
    use HandlesAccountTransactions, AdminLog, SoftDeletes,HasFactory;
    public function getTransactionType(): string
    {
        if ($this->status === 'approved') {
            return 'in';
        } elseif ($this->status === 'pending' || $this->status === 'rejected') {
            return 'out';
        }
        return 'in';
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
            ->where('model', '=', get_class($this));
    }
}
