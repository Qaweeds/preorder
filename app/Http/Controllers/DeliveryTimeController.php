<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DeliveryTimeController extends Controller
{
    public static function deliveryTime($way, $country, $maketime)
    {
        $arr = [
            'Земля' => [0, 30, 30, 30, 20, 15, 1, 1],
            'Самолет' => [0, 10, 10, 10, 7, 5, 1, 1]
        ];
        if ($maketime) return Carbon::parse($maketime)->addDays($arr[$way][$country]);
        return Carbon::now()->addDays($arr[$way][$country]);
    }
}
