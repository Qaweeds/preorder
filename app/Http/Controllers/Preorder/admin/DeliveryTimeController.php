<?php

namespace App\Http\Controllers\Preorder\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryTimeRequest;
use App\Models\Preorder\DeliveryTime;
use Illuminate\Http\Request;

class DeliveryTimeController extends Controller
{
    public function getValue(Request $r)
    {
        return DeliveryTime::query()
            ->where('country_id', $r->input('delivery_time-country'))
            ->where('delivery', $r->input('delivery_time-delivery'))
            ->value('days');
    }

    public function store(DeliveryTimeRequest $r)
    {
        DeliveryTime::query()
            ->where('country_id', $r->input('delivery_time-country'))
            ->where('delivery', $r->input('delivery_time-delivery'))
            ->update(['days' => $r->input('delivery_time-val')]);

        return redirect()->route('admin.index')->with('success', 'Успешно обновлено');
    }

    public function showAll()
    {
        $table = DeliveryTime::makeTAble();

        return view('preorder.admin.table', compact('table'));
    }
}
