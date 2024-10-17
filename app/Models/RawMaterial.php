<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterial extends Model
{
    use AdminLog, SoftDeletes,HasFactory;

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'brand_raw_material');
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'size_raw_material');
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'color_raw_material');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RawMaterialCategory::class, 'raw_material_category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function rawMaterialPurchases(): BelongsToMany
    {
        return $this->belongsToMany(RawMaterialPurchase::class, 'purchase_raw_material')
            ->withPivot( 'raw_material_purchase_id',
                'raw_material_id',
                'brand_id',
                'size_id',
                'color_id',
                'warehouse_id',
                'price',
                'quantity',
                'total_price');
    }
}
