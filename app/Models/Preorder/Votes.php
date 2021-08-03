<?php

namespace App\Models\Preorder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id'];
}
