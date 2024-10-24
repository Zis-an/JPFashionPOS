<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSellPrice extends Model
{
    use AdminLog, HasFactory;

    public function productStock()
    {
        return $this->belongsTo(ProductStock::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
