<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\AddressResource;
use App\Http\Resources\Api\CustomerResource;

class UserController extends BaseController
{
    public function __construct(
        protected UserService $userService,
    )
    {
        $this->userService = $userService;
    }
    public function getCustomerDetails()
    {
        try {
            $userDetails = auth()->user();

            $message = $userDetails ? "Profile found successfully" : "Profile not found";
            return $this->responseJson(true, 200, $message, new CustomerResource($userDetails));

        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something went wrong", (object)[]);
        }
    }
    public function updateCustomerDetails(Request $request)
    {
        try {
            $userDetails = auth()->user();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,'.$userDetails->id.',id,deleted_at,NULL',
                'occupation' => 'nullable|string',
                'gender' => 'required|string',
            ]);
            if ($validator->fails()) return $this->responseJson(false, 200, $validator->errors()->first(), (object)[]);
            DB::beginTransaction();
            $nameArr = explode(' ', $request->name);
            $firstName = $nameArr[0];
            $lastName = (count($nameArr) > 1) ? $nameArr[1] : '';
            $request->merge(['first_name' => $firstName, 'last_name' => $lastName, 'role' => 'customer', 'is_registered' => 1]);
            $isUserUpdated = $this->userService->updateUser($request->except(['_token', 'name']), $userDetails->id);

            $message = $isUserUpdated ? "Profile updated successfully" : "Profile not updated";
            DB::commit();
            return $this->responseJson(true, 200, $message, new CustomerResource($userDetails->fresh()));

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something Went Wrong", (object)[]);
        }
    }
    public function listCustomerAddresses(){
        $addresses = auth()->user()->addresses;
        return $this->responseJson(true,200,'Addresses found successfully',AddressResource::collection($addresses));
    }
    public function addUpdateCustomerAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_address' => 'required|string',
            'type' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), []);
        }
        DB::beginTransaction();
        try {
            $addressId = null;
            $actionText = 'added';
            if($request->uuid){
                $addressId = uuidtoid($request->uuid,'addresses');
                $actionText = 'updated';
            }
            $isAddressAltered = $this->userService->createOrUpdateCustomerAddress($request->except(['_token']), $addressId);
            $message = $isAddressAltered ? "Address successfully ".$actionText : "Something wrong happened";
            DB::commit();
            return $this->responseJson(true, 200, $message, AddressResource::collection(auth()->user()->addresses->fresh()));
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}
