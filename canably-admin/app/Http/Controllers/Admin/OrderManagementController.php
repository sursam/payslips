<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderManagementController extends BaseController
{

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService= $orderService;
    }

    public function index(Request $request){
        $this->setPageTitle('All Orders');
        $orders= $this->orderService->getOrders()->sortByDesc('id')->paginate(15);
        return view('admin.order.index',compact('orders'));
    }

    public function viewOrder(Request $request,$uuid){
        $this->setPageTitle('Order Details');
        $id= uuidtoid($uuid,'orders');
        $order= $this->orderService->findOrder($id);
        return view('admin.order.view',compact('order'));
    }
}
