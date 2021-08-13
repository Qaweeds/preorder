<?php

namespace App\Models\Preorder;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['value'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public static function dataForSetup()
    {
        $country = self::query()->toBase()->join('countries', 'country_id', '=', 'id')
            ->distinct()->get(['country_id', 'name'])->toArray();
        $delivery = self::query()->distinct()->pluck('delivery')->toArray();

        return compact('country', 'delivery');
    }

    public static function makeTable()
    {
        $all = self::query()->with('country:id,name')->get();
        foreach ($all as $one) {
            $data[$one->delivery][$one->country->name] = $one->days;
        }

        $t = '<table class="admin-table">';
        $t .= '<thead>';
        $t .= '<th>Транспорт</th>';
        $t .= '<th>Страна</th>';
        $t .= '<th>Дни</th>';
        $t .= '</thead>';
        $t .= '<tbody>';

        $transport_check = 'Земля';

        foreach ($data as $transport => $value) {
            foreach ($value as $country => $days) {

                if ($transport == $transport_check) {
                    $t .= '<tr>';
                } else {
                    $t .= '<tr class="row-separator">';
                }
                $transport_check = $transport;

                $t .= '<td>' . $transport . '</td>' . '<td>' . $country . '</td>' . '<td>' . $days . '</td></tr>';
            }
        }
        $t .= '</tbody></table>';

        return $t;
    }
}
