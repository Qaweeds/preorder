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

    public static function dataForSetup()
    {
        $delivery = self::query()->distinct()->pluck('delivery')->toArray();
        $country = self::query()->distinct()->pluck('country')->toArray();
        $season = self::query()->distinct()->pluck('season')->toArray();
        $goods_group = self::query()->distinct()->pluck('gg')->toArray();

        return compact('delivery', 'country', 'season', 'goods_group');
    }

}
