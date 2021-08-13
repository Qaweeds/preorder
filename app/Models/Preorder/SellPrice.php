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

    public static function makeTable()
    {
        $all = self::query()->toBase()->get();
        $gg = self::query()->distinct()->pluck('gg')->toArray();

        foreach ($all as $one) {
            $data[$one->country][$one->channel][$one->season][$one->gg] = $one->value;
        }

        $t = '<table class="admin-table">';
        $t .= '<thead>';
        $t .= '<th>Страна</th>';
        $t .= '<th>Канал продаж</th>';
        $t .= '<th>Сезон</th>';

        foreach ($gg as $g) {
            $t .= '<th>' . $g . '</th>';
        }

        $t .= '</thead>';
        $t .= '<tbody>';

        $country_check = 'Бангладеш';

        foreach ($data as $country => $value) {

            foreach ($value as $channel => $val) {
                foreach ($val as $season => $v) {

                    if ($country == $country_check) {
                        $t .= '<tr>';
                    } else {
                        $t .= '<tr class="row-separator">';
                    }
                    $country_check = $country;

                    $t .= '<td>' . $country . '</td>';
                    $t .= '<td>' . $channel . '</td>';
                    $t .= '<td>' . $season . '</td>';
                    foreach ($v as $percent) {
                        $t .= '<td>' . $percent . '%' . '</td>';
                    }
                    $t .= '</tr>';

                }
            }
        }

        $t .= '</tbody></table>';

        return $t;
    }
}
