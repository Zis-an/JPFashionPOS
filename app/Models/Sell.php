<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function product()
    {
        return $this->hasmany(Product::class, 'id', 'product_id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
