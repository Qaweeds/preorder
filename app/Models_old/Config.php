<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $table = 'config';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'value',
    ];
}
