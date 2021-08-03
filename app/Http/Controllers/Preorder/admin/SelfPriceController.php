<?php

namespace App\Http\Controllers\Preorder\admin;

use App\Http\Requests\Admin\SelfpriceRequest;
use App\Models\Preorder\SelfPrice;
use Illuminate\Http\Request;

class SelfPriceController extends BaseController
{
    public function getSelfPriceValue(Request $r)
    {
        return SelfPrice::query()
            ->where('delivery', $r->input("selfprice-delivery"))
            ->where('gg', $r->input("selfprice-group"))
            ->where('country', $r->input("selfprice-country"))
            ->where('season', $r->input("selfprice-season"))
            ->value('value');
    }

    public function store(SelfpriceRequest $r)
    {;
        SelfPrice::query()
            ->where('delivery', $r->input("selfprice-delivery"))
            ->where('gg', $r->input("selfprice-group"))
            ->where('country', $r->input("selfprice-country"))
            ->where('season', $r->input("selfprice-season"))
            ->update(['value' => $r->input('selfprice-val')]);

        return redirect()->route('admin.index')->with('success', 'Успешно обновлено');
    }
}
