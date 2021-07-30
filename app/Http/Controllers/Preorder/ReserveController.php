<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReserveRequest;
use App\Models\Preorder\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReserveController extends Controller
{
    public function __invoke(ReserveRequest $request)
    {
        $reserve = new Reserve;
        $reserve->user_id = Auth::user()->id;
        $reserve->product_id = $request->reserve;
        $reserve->quantity = $request->get('reserve-amount');
        $reserve->save();
    }
}
