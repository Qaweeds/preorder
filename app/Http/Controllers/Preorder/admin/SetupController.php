<?php

namespace App\Http\Controllers\Preorder\admin;


use App\Models\Preorder\DeliveryTime;
use App\Models\Preorder\SelfPrice;
use App\Models\Preorder\SellPrice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SetupController extends BaseController
{
    public function index()
    {
        $data['selftprice'] = SelfPrice::dataForSetup();
        $data['sellprice'] = SellPrice::dataForSetup();
        $data['deliveryTime'] = DeliveryTime::dataForSetup();
        $data['testusers'] = User::testUsers();
        return view('preorder.admin.index', $data);
    }

    public function test(Request $r)
    {
        if ($r->has('loginAs')) {
            $r->validate([
                'loginAs' => 'exists:users,id'
            ]);

            Auth::loginUsingId($r->input('loginAs'));

            return redirect('/');
        }
    }

}
