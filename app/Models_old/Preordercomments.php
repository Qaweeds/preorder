<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preordercomments extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
    ];
}
