<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preorderproducts extends Model
{
    protected $fillable = [
        'user_id',
        'raiting',
        'vote_counter',
        'total',
        'photo',
        'category',
        'category2',
        'priznak',
        'country',
        'delivery',
        'channel',
        'season',
        'date_sale',
        'price',
        'selfprice',
        'sale_price',
        'comment',
        'active',
        'ordered'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function countries() {
        return $this->belongsTo(Countries::class, 'country', 'id');
    }
}
