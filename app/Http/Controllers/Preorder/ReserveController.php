<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Requests\ReserveRequest;
use App\Models\Preorder\Product;
use App\Models\Preorder\Reserve;
use Illuminate\Support\Facades\Auth;

class ReserveController extends BaseController
{
    public function __invoke(ReserveRequest $request)
    {
        $item_owner = Product::query()->where('id', $request->reserve)->value('user_id');
        if (Auth::user()->id == $item_owner) abort(403);
        $reserve = new Reserve;
        $reserve->user_id = Auth::user()->id;
        $reserve->product_id = (int)$request->reserve;
        $reserve->quantity = (int)$request->get('reserve-amount');
        $reserve->save();
        return json_encode($reserve);
    }
}
