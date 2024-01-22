<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Services\Payment\PaymentService;
use App\Services\Location\CountryService;

class PaymentController extends BaseController
{
    public function __construct(protected CountryService $countryService,protected UserService $userService,protected PaymentService $paymentService ){
        $this->countryService= $countryService;
        $this->userService= $userService;
        $this->paymentService= $paymentService;
    }

    public function checkout(Request $request){
        $this->setPageTitle('Customer Checkout');
        if($request->post()){
            $request->validate([
                'first_name'=> 'required|min:2',
                'last_name'=> 'required|min:2',
            ]);
        }
        $countries= $this->countryService->getCountries();
        return view('customer.payment.checkout',compact('countries'));
    }

    public function order(Request $request){
        if($request->post()){
            $request->validate([
                'first_name'=> 'required|string|min:2',
                'last_name'=> 'required|string|min:2',
                'phone_number'=> 'required|numeric|min:100000000',
                'full_address.address_line_one'=> 'required|string|min:3',
                'country'=> 'required|exists:countries,slug',
                'state'=> 'required|exists:states,slug',
                'city'=> 'required|exists:cities,slug',
                'zip_code'=> 'required|numeric|min:10000',
            ]);
            DB::beginTransaction();
            try{
                $request->merge(['country_id'=>slugtoid($request->country,'countries'),'state_id'=>slugtoid($request->state,'states'),'city_id'=>slugtoid($request->city,'cities')]);
                $isOrderCompleted = $this->paymentService->createOrder($request->except('_token'));
                if($isOrderCompleted){
                    DB::commit();
                    return $this->responseRedirect('customer.order.list','Order placed successfully','success');
                }
            }catch(\Exception $e){
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went Wrong','error',true);
            }
        }
    }
}
