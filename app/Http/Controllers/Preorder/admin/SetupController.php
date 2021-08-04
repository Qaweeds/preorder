<?php

namespace App\Http\Controllers\Preorder\admin;


use App\Models\Preorder\DeliveryTime;
use App\Models\Preorder\SelfPrice;
use App\Models\Preorder\SellPrice;


class SetupController extends BaseController
{
    public function index()
    {
        $data['selftprice'] = SelfPrice::dataForSetup();
        $data['sellprice'] = SellPrice::dataForSetup();
        $data['deliveryTime'] = DeliveryTime::dataForSetup();
        return view('preorder.admin.index', $data);
    }


}
