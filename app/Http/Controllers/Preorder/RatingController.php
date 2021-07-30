<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Models\Preorder\Product;
use Illuminate\Support\Facades\Request;


class RatingController extends Controller
{
    public function __invoke(VoteRequest $request)
    {
        $item = Product::find($request->model);
        if (empty($item)) return route('main.index');

        if (is_null($item->rating)) {
            $item->votes_count = 1;
            $item->rating_total = $request->mark;
        } else {
            $item->votes_count++;
            $item->rating_total += $request->mark;
        }
        $item->rating = $item->rating_total / $item->votes_count;
        $item->save();
//        dd($item->rating);
        return round($item->rating, 1);
    }


}
