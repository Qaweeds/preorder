<?php

namespace App\Models\Preorder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellPrice extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =
        [
            'channel',
            'country',
            'season',
            'gg',
            'value',
        ];
}
