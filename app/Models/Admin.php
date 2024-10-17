<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\AdminLog;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, AdminLog,SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adminlte_profile_url(){
        return 'admin/profile';
    }
    public function adminlte_image(){
        if (auth()->user()->photo){
            return asset('uploads/'.auth()->user()->photo);
        }
        return asset('self/avatar.webp');
    }
    public function adminlte_desc(){
        return auth()->user()->name;
    }
}
