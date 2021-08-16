<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
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

        foreach ($arr as $d) {
            $arr2[$d["Страна"]][$d['Канал продаж']][$d['Сезон']] = array_splice($d, 3);
        }
        array_pop($arr2);
        foreach ($arr2 as $country => $value) {
            foreach ($value as $channel => $val) {
                foreach ($val as $season => $v) {
                    foreach ($v as $gg => $amount) {
                        dd('db update');
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


//    public function __invoke()
//    {
//        $currencies = Exchange::query()->pluck('currency');
//        dd('q');
//        foreach ($currencies as $code) {
//            Exchange::query()->where('currency', $code)->update(['value' => (float)$this->getCurrency($code)]);
//        }
//
//    }

    public static function getCurrency($code)
    {
        $cur = simplexml_load_file('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode=' . $code);
        return $cur->currency->rate;
    }

}
