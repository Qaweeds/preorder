<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Goodsgroup;
use App\Models\Preorder\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditController extends Controller
{
    public function index($id)
    {
        $data['item'] = Product::query()->findOrFail($id);
        $data['countries'] = Country::query()->toBase()->get();
        $data['groups'] = Goodsgroup::query()->toBase()->get();
        return view('preorder.edit', $data);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::query()->findOrFail($id);
        if ($product->user_id != Auth::user()->id) return back();

        if (isset($request->file)) {
            $photo = '';
            foreach ($request->file as $pic) {
                Storage::putFileAs('public/preorder/images', $pic, $pic->getClientOriginalName());
                $photo .= $pic->getClientOriginalName() . ',';
            }
            $photo = substr($photo, 0, -1);
        }

        $channel = '';
        foreach ($request->channel as $ch) {
            $channel .= $ch . ',';
        }
        $channel = substr($channel, 0, -1);

        $product->goodsgroup_id = $request->group;
        $product->category_id = Category::where('name', $request->category)->value('id');
        $product->country_id = $request->country;
        $product->ready_or_not = $request->ready_or_not;
        $product->delivery = $request->delivery;
        $product->season = $request->season;
        $product->date_start_sale = now();
        $product->price = $request->price;
        $product->channel = $channel;

        if (isset($photo)) $product->photo = $photo;
//        dd($product);
        $product->save();

        return  redirect()->route('main.index')->with('success', 'Успешно обновлено');

    }
}
