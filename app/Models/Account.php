<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AdminLog;

class Account extends Model
{
    use AdminLog, SoftDeletes, HasFactory;


    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccountTransaction::class);
    }
}
