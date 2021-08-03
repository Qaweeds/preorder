<?php

namespace App\Models;

use App\Http\Controllers\PreorderController;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    private $can_see_all_prices = [
        'Админ',
        'Директор',
        'Товаровед',
        'Закупка',
    ];

    protected $fillable = [
        'email',
        'name',
        'role',
        'login',
    ];

    public function can_see_all_prices()
    {
        return in_array($this->role, $this->can_see_all_prices);
    }

    public function can_decide()
    {
        return $this->role == 'Директор' || $this->role == 'Админ';
    }

    public function admin()
    {
        return $this->role == 'Админ';
    }
}
