<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AdminLog;

class Department extends Model
{
    use AdminLog, SoftDeletes,HasFactory;

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
