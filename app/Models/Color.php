<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use AdminLog, SoftDeletes,HasFactory;

    public function rawMaterials()
    {
        return $this->belongsToMany(RawMaterial::class, 'brand_raw_material');
    }
}
