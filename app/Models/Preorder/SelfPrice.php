<?php

namespace App\Models\Preorder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfPrice extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =
        [
            'delivery',
            'country',
            'season',
            'gg',
            'value',
        ];
}
