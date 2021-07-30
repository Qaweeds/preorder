<?php

namespace App\Http\Controllers\Preorder;

use App\Http\Controllers\Controller;
use App\Models\Preorder\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $items = Product::with(
            [
                'user:id,name',
                'gg:id,alias',
                'category:id,name',
                'country:id,name,currency',
                'comments',
                'reserve'
            ]
        )->get();
//        dd($items);
        $user = Auth::user();
        return view('preorder.index', compact('items', 'user'));
    }
}
