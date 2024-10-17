<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use AdminLog, SoftDeletes,HasFactory;
    public function raw_material_stocks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RawMaterialStock::class);
    }
}
