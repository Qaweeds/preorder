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

    public static function dataForSetup()
    {
        $channel = self::query()->distinct()->pluck('channel')->toArray();
        $country = self::query()->distinct()->pluck('country')->toArray();
        $season = self::query()->distinct()->pluck('season')->toArray();
        $goods_group = self::query()->distinct()->pluck('gg')->toArray();

        return compact('channel', 'country', 'season', 'goods_group');
    }
}
