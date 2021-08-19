<?php

namespace App\Http\Controllers\Preorder\admin;

use App\Http\Controllers\Preorder\BaseController as MainBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends MainBaseController
{
    public function __construct(Request $r)
    {
        parent::__construct();

        if ($r->has('loginAs')) {
            $r->validate([
                'loginAs' => 'min:993|max:999'
            ]);

            Auth::loginUsingId($r->input('loginAs'));

            return redirect('/');
        }
    }

}
