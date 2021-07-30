<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservedpreorders extends Model
{
   protected $fillable = [
       'model_id',
       'user_id',
       'quantity',
   ];
}
