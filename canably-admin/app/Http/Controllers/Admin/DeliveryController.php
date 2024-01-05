<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Services\Order\OrderService;
use App\Http\Controllers\BaseController;
use App\Notifications\AgentNotification;

class DeliveryController extends BaseController
{

    protected $orderService,$userService;

    public function __construct(OrderService $orderService,UserService $userService)
    {
        $this->orderService = $orderService;
        $this->userService = $userService;
    }
    public function index(Request $request)
    {
        $this->setPageTitle('Delivery Lists');
        $orders = $this->orderService->getOrders()->sortByDesc('id')->paginate(15);
        return view('admin.delivery.list', compact('orders'));
    }
    public function edit(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Delivery');
        $id = uuidtoid($request->uuid, 'orders');
        $order = $this->orderService->findOrder($id);
        $agents= $this->userService->getEmployees('delivery-agent','employee');
        return view('admin.delivery.edit', compact('order','agents'));
    }

    public function assignAgent(Request $request, $uuid){
        $request->validate([
            'agent' =>'required|string|exists:users,uuid',
            'comment' =>'required|string',
        ]);
        DB::beginTransaction();
        try {
            $id = uuidtoid($uuid, 'orders');
            $user_id = uuidtoid($request->agent,'users');
            $user= $this->userService->findById($user_id);
            $order = $this->orderService->findOrder($id);
            $description = $order->status_description;
            $description[$request->status]['time'] = Carbon::now()->format('Y-m-d H:i:s');
            $description[$request->status]['comment'] = $request->comment;
            $isOrderUpdated= $this->orderService->updateOrder(['delivery_status'=>true,'status_description'=>$description],$id);
            if($isOrderUpdated){
                $isDeliveryAgentAssigned= $order->deliveryStatus()->create([
                    'user_id' => uuidtoid($request->agent,'users'),
                ]);
                if($isDeliveryAgentAssigned){
                    DB::commit();
                    $data= [
                        'type'=>'deliveryAssigned',
                        'order_no'=> $order->order_no,
                        'title'=>'New Delivery'
                    ];
                    $user->notify(new AgentNotification($data));
                    return $this->responseJson(true,200,'Agent Assigned Successfully');
                }
                return $this->responseJson(false,500,'Something went wrong');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false,500,'Something went wrong');
        }

    }
}
