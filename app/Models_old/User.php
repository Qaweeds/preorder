<?php

namespace App\Models;

use App\Http\Controllers\PreorderController;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email',
        'name',
        'phone',
        'region_id',
        'department_id',
        'position',
        'role_id',
        'status',
        'comment',
        'password',
        'settings',
        'login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function is_admin()
    {
        return $this->role_id == 1;
    }

    public function is_director()
    {
        return $this->role_id == 3;
    }

    public function is_tovaroved()
    {
        return $this->department_id == 14;
    }
    public function is_zakupka()
    {
        return $this->department_id == 3;
    }
}
