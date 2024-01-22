<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class OrderController extends BaseController
{
    public function index(Request $request){
        return view('customer.order.index');
    }
    public function purchase(Request $request){
        $orders= auth()->user()->purchaseOrders->paginate(10);
        return view('customer.order.purchase',compact('orders'));
    }
}
