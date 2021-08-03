<?php

namespace App\Http\Controllers\Preorder\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SellpriceRequest;
use App\Models\Preorder\SellPrice;
use Illuminate\Http\Request;

class SellPriceController extends Controller
{
    public function getSellPriceValue(Request $r)
    {
        return SellPrice::query()
            ->where('channel', $r->input("sellprice-channel"))
            ->where('country', $r->input("sellprice-country"))
            ->where('season', $r->input("sellprice-season"))
            ->where('gg', $r->input("sellprice-group"))
            ->value('value');
    }

    public function store(SellpriceRequest $r)
    {
        SellPrice::query()
            ->where('channel', $r->input("sellprice-channel"))
            ->where('gg', $r->input("sellprice-group"))
            ->where('country', $r->input("sellprice-country"))
            ->where('season', $r->input("sellprice-season"))
            ->update(['value' => $r->input('sellprice-val')]);

        return redirect()->route('admin.index')->with('success', 'Успешно обновлено');
    }
}
