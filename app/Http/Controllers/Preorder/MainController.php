<?php

namespace App\Http\Controllers\Preorder;


use App\Http\Requests\FilterRequest;
use App\Models\Preorder\Product;
use Illuminate\Support\Facades\Auth;

class MainController extends BaseController
{
    public function index()
    {
        $user = Auth::user();
        $items = Product::with(
            ['user:id,name',
                'gg:id,alias',
                'category:id,name',
                'country:id,name,currency',
                'comments',
                'reserve'
            ]);
        if ($user->can_see_all_prices()) {
            $items = $items->get();
        } else {
            $items = $items->where('channel', 'LIKE BINARY', '%' . $user->role . '%')->get();
        }

        return view('preorder.index', compact('items', 'user'));
    }

    public function filter(FilterRequest $r)
    {
        $user = Auth::user();
        $items = Product::with(
            ['user:id,name',
                'gg:id,alias',
                'category:id,name',
                'country:id,name,currency',
                'comments',
                'reserve'
            ]);
        if (!empty($r->season)) $items = $items->where('season', $r->season);
        if (!empty($r->country)) $items = $items->where('country_id', $r->country);
        if (!empty($r->fio)) $items = $items->where('user_id', $r->fio);
        if (!empty($r->category)) $items = $items->where('category_id', $r->category);

        if ($user->can_see_all_prices()) {
            if (!empty($r->channel)) {
                $items = $items->where('channel', 'LIKE BINARY', '%' . $r->channel . '%');
            }
        } else {
            $items = $items->where('channel', 'LIKE BINARY', '%' . $user->role . '%');
        }
        $items = $items->get();
        return view('preorder.index', compact('items', 'user'));
    }
}
