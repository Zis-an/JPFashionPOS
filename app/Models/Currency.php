<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use AdminLog, SoftDeletes, HasFactory;

    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($currency) {
            if ($currency->isdefault && $currency->status === false) {
                throw new \Exception('The default currency must have status set to true.');
            }
        });
    }
}
