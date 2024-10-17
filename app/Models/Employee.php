<?php

namespace App\Models;

use App\Traits\AdminLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use AdminLog, SoftDeletes,HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
