<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Preorder\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends BaseController
{
    public function success(OrderRequest $r)
    {
        $item = Product::query()->findOrFail($r->id);

        if (!Auth::user()->can_decide() && Auth::user()->id != $item->user_id) abort(400);
        $item->ordered = 1;
        $item->save();

        return "#card-" . $item->id;
    }

    public function denied(OrderRequest $r)
    {

        $item = Product::query()->findOrFail($r->id);

        if (!Auth::user()->can_decide() && Auth::user()->id != $item->user_id) abort(400);

        $item->ordered = 0;
        $item->save();

        return "#card-" . $item->id;
    }
}
