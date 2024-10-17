<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use AdminLog, SoftDeletes, HasFactory;

    public function productionHouse()
    {
        return $this->belongsTo(ProductionHouse::class, 'production_house_id');
    }

    public function showroom()
    {
        return $this->belongsTo(Showroom::class, 'showroom_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
