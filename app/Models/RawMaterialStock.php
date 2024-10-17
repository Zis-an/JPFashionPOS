<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterialStock extends Model
{
    use AdminLog, SoftDeletes,HasFactory;

    public function raw_material()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
