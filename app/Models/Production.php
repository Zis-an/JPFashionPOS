<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use AdminLog, SoftDeletes, HasFactory;

//    public function getTransactionType(): string
//    {
//        if ($this->status === 'approved') {
//            return 'out';
//        } elseif ($this->status === 'pending' || $this->status === 'rejected') {
//            return 'in';
//        }
//        return 'out';
//    }

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
    public function rawMaterials()
    {
        return $this->hasMany(ProductionRawMaterial::class);
    }

    public function products()
    {
        return $this->hasMany(ProductionProduct::class,);
    }

//    public function accountTransaction(): HasOne
//    {
//        return $this->hasOne(AccountTransaction::class, 'model_id')
//            ->where('model', '=', get_class($this));
//    }

}
