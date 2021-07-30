<?php

namespace App\Http\Controllers;

use App\Models\Preorder\SelfPrice;
use App\Models\Preorder\SellPrice;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Test extends Controller
{
    public function __invoke()
    {
        $xls = IOFactory::load('../storage/app/public/xml/sellprice.xlsx');
        $data = $xls->getActiveSheet()->toArray();

        for ($i = 1; $i < count($data); $i++) {
            $arr[$i] = array_combine($data[0], $data[$i]);
        }
        foreach ($arr as & $q) {
            array_pop($q);
        }
        foreach ($arr as $d) {
            $arr2[$d["Страна"]][$d['Канал продаж']][$d['Сезон']] = array_splice($d, 3);
        }
        array_pop($arr2);
        foreach ($arr2 as $country => $value) {
            foreach ($value as $channel => $val) {
                foreach ($val as $season => $v) {
                    foreach ($v as $gg => $amount) {
                        SellPrice::query()->create(
                            [
                                'country' => $country,
                                'channel' => $channel,
                                'season' => $season,
                                'gg' => $gg,
                                'value' => trim($amount, '%')
                            ]
                        );
                    }
                }
            }
        }
    }
}
