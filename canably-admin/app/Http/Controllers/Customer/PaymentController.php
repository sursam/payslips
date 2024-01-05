<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BaseController;
use App\Services\Payment\PaymentService;

class PaymentController extends BaseController
{
    protected $userService;
    protected $paymentService;
    public function __construct(
        UserService $userService,
        PaymentService $paymentService
    ) {
        $this->userService = $userService;
        $this->paymentService = $paymentService;
    }

    public function checkout(Request $request)
    {
        $getOrderSession= session()->get('order-'.auth()->user()->uuid,[]);
        if(empty($getOrderSession)){
            return $this->responseRedirect('customer.cart','Something went wrong','error',true);
        }
        $this->setPageTitle('Customer Checkout');
        $default_address = auth()->user()->addressBook->where('zip_code',$getOrderSession['pincode']);
        $default_address = $default_address->where('is_default',true)->first() ?? $default_address->first();
        // dd($default_address);
        $carts= auth()->user()->carts;
        if($request->post()){
            session()->put('order-'.auth()->user()->uuid.'.address',$request->except('_token'));
            return $this->responseRedirect('payment.details','Address added successfully','success');
        }
        return view('customer.payment.checkout',compact('carts','default_address','getOrderSession'));
    }
    public function paymentDetails(Request $request)
    {
        $getOrderSession= session()->get('order-'.auth()->user()->uuid,[]);
        if(empty($getOrderSession)){
            return $this->responseRedirect('customer.cart','Something went wrong','error',true);
        }
        $this->setPageTitle('Payment Details');
        if($request->post()){
            $order= session()->get('order-'.auth()->user()->uuid,[]);
            $request->merge(['order'=> $order]);
            DB::beginTransaction();
            try{
                $isOrderCompleted = $this->paymentService->createOrder($request->except('_token'));
                if($isOrderCompleted){
                    DB::commit();
                    return $this->responseRedirect('payment.success','Order placed successfully','success');
                }
            }catch(\Exception $e){
                DB::rollBack();
                Log::channel('payment')->error($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went Wrong','error',true);
            }
        }
        return view('customer.payment.card');
    }
    public function paymentSucces(Request $request)
    {
        $this->setPageTitle('Payment Successfull');
        return view('customer.payment.success');
    }

}
