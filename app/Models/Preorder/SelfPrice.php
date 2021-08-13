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

    public static function makeTAble()
    {
        $all = self::query()->toBase()->get();
        $gg = self::query()->distinct()->pluck('gg')->toArray();

        foreach ($all as $one) {
            $data[$one->delivery][$one->country][$one->season][$one->gg] = $one->value;
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

        $transport_check = 'Земля';

        foreach ($data as $transport => $value) {

            foreach ($value as $country => $val) {
                foreach ($val as $season => $v) {

                    if ($transport == $transport_check) {
                        $t .= '<tr>';
                    } else {
                        $t .= '<tr class="row-separator">';
                    }
                    $transport_check = $transport;

                    $t .= '<td>' . $transport . '</td>';
                    $t .= '<td>' . $country . '</td>';
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
