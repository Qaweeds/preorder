<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoteRequest;
use App\Models\Preorder\Product;
use App\Models\Preorder\Votes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


class RatingController extends BaseController
{
    public function __invoke(VoteRequest $request)
    {
        $vote = Votes::query()->where('user_id', Auth::user()->id)->where('product_id', $request->model)->first();
        if (is_null($vote)) {

            Votes::query()->create(['user_id' => Auth::user()->id, 'product_id' => $request->model]);

            /*------------------------------------*/

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
            return round($item->rating, 1);
        } else {
            abort(400);
        }
    }


}
