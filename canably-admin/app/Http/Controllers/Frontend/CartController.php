<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

/* use App\Services\Banner\BannerService; */

class CartController extends BaseController
{

    public function cart(Request $request)
    {
        $this->setPageTitle('Cart');
        return view('frontend.cart');
    }

}
