<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;

use App\Http\Requests\NewProductRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Goodsgroup;
use App\Models\Preorder\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateController extends Controller
{
    public function index()
    {
//        if(Auth::user()->role != 'Закупка') return back();
        $data['countries'] = Country::query()->toBase()->get();
        $data['groups'] = Goodsgroup::query()->toBase()->get();
        return view('preorder.create', $data);
    }

    public function getCatByGroup(Request $r)
    {
        $alias = Goodsgroup::where('id', $r->get('group'))->value('alias');
        $cat = Category::where('gg', 'like', '%' . $alias . '%')->pluck('name');
        return $cat;
    }

    public function store(NewProductRequest $request)
    {
        $photo = '';
        $channel = '';
        foreach ($request->file as $pic) {
            Storage::putFileAs('public/preorder/images', $pic, $pic->getClientOriginalName());
            $photo .= $pic->getClientOriginalName() . ',';
        }
        $photo = substr($photo, 0, -1);
        foreach ($request->channel as $ch) {
            $channel .= $ch . ',';
        }
        $channel = substr($channel, 0, -1);

        $product = new Product;
        $product->user_id = Auth::user()->id;
        $product->goodsgroup_id = $request->group;
        $product->category_id = Category::where('name', $request->category)->value('id');
        $product->country_id = $request->country;
        $product->photo = $photo;
        $product->ready_or_not = $request->ready_or_not;
        $product->delivery = $request->delivery;
        $product->season = $request->season;
        $product->date_start_sale = now();
        $product->price = $request->price;
        $product->comment = $request->comment;
        $product->channel = $channel;
        $product->save();

        return redirect()->route('create.index')
            ->withCookie(cookie('country', $request->country, 60 * 24))
            ->with('success', 'Успешно добавлено');
    }
}
