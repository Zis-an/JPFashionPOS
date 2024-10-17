<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Define a polymorphic relationship with any model (e.g., Expense, Order).
     */
    public function model(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'model', 'model_id');
    }
}
