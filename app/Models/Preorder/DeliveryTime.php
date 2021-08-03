<?php

namespace App\Models\Preorder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['value'];
}
