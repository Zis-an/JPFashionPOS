<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Sell extends Model
{
    use AdminLog, SoftDeletes, HasFactory;

    public function productStock()
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'product_id');
    }

    public function showroom()
    {
        return $this->hasMany(Showroom::class, 'showroom_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function salesman()
    {
        return $this->hasOne(Admin::class, 'id', 'salesman_id');
    }

    public function sell_stocks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasmany(SellStock::class);
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
    public function currency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $sale->unique_sale_id = $sale->generateUniqueSaleId();
        });
    }

    // Generate a unique sale ID with uniqueness check
    public function generateUniqueSaleId()
    {
        do {
            $uniqueId = 'INV' . strtoupper(Str::random(8));
        } while (self::where('unique_sale_id', $uniqueId)->exists());

        return $uniqueId;
    }
}
