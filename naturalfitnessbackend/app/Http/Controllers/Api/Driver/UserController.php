<?php

namespace App\Http\Controllers\Api\Driver;

// use App\Models\User\User;
use App\Mail\SendMailable;
use App\Models\Site\Setting;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\BaseController;
use App\Services\Vehicle\VehicleService;
use Illuminate\Support\Facades\Validator;
// use App\Http\Resources\Api\VehicleResource;
// use App\Http\Resources\Api\UserDetailsResource;
use App\Http\Resources\Api\DriverResource;
use App\Http\Resources\Api\WalletResource;
use App\Services\Category\CategoryService;
use App\Http\Resources\Api\DriverProfileResource;
use App\Notifications\SiteNotification;
use App\Http\Resources\Api\NotificationResource;
use App\Notifications\SendPushNotification;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    public function __construct(
        protected UserService $userService,
        protected VehicleService $vehicleService,
        protected CategoryService $categoryService,
    )
    {
        $this->userService = $userService;
        $this->vehicleService = $vehicleService;
        $this->categoryService = $categoryService;
    }
    public function getDriverDetails()
    {
        try {
            $userDetails = auth()->user();

            $message = $userDetails ? "Profile found successfully" : "Profile not found";
            return $this->responseJson(true, 200, $message, new DriverResource($userDetails));

        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something went wrong", (object)[]);
        }
    }
    public function updateDriverDetails(Request $request)
    {
        $user_id = auth()->user()->id;
        $vehicle_id = auth()->user()->vehicle?->id;
        $validator = Validator::make($request->all(), [
            'step' => 'required|string|in:first,second,third',
            'name' => 'required_if:step,first|string',
            'email' => 'nullable|email|unique:users,email,'.$user_id.',id,deleted_at,NULL',
            // 'email' => Rule::unique('users', 'email')->ignore(auth()->user()->email)->whereNull('deleted_at')->orWhereNotNull('deleted_at'),
            'category_id' => 'required_if:step,first|exists:categories,uuid',
            'sub_category_id'=> 'sometimes|exists:categories,uuid|nullable',
            'body_type_id'=> 'sometimes|exists:categories,uuid|nullable',
            'aadhar_front' => 'required_if:step,second',
            'aadhar_back' => 'required_if:step,second',
            'licence_front' => 'required_if:step,second',
            'licence_back' => 'required_if:step,second',
            'registration_number' => 'required_if:step,third|string|reg_unique:vehicles,registration_number,'.$vehicle_id.',id,deleted_at,NULL',
            // 'company_id' => 'required_if:step,third|exists:companies,uuid',
            'rc_front' => 'required_if:step,third',
            'rc_back' => 'required_if:step,third',
            'vehicle_image' => 'required_if:step,third',
        ], [
            'reg_unique' => 'Vehicle number already exists!',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), []);
        }
        DB::beginTransaction();
        $request->merge(['role' => 'driver']);
        try {
            switch ($request->step) {
                case 'first':
                    $catId = uuidtoid($request->category_id,'categories');
                    $vehicleTypeData = $this->categoryService->findCategoryById($catId);
                    if($vehicleTypeData->slug == 'truck' && !$request->sub_category_id && !$request->body_type_id){
                        return $this->responseJson(false, 422, 'Truck type & body type is required!', []);
                    }else{
                        $nameArr = explode(' ', $request->name);
                        $firstName = $nameArr[0];
                        $lastName = (count($nameArr) > 1) ? $nameArr[1] : '';
                        $request->merge(['first_name' => $firstName, 'last_name' => $lastName, 'registration_step' => 1]);
                        if(!$request->sub_category_id){
                            $request->merge(['sub_category_id' => null]);
                        }
                        if(!$request->body_type_id){
                            $request->merge(['body_type_id' => null]);
                        }
                        $isUserUpdated = $this->userService->updateUser($request->except(['_token', 'name']), $user_id);
                        $vehicleData = auth()->user()->vehicle ?? auth()->user()->vehicle()->create(['is_active' => false]);
                        $request->merge(['company_id' => null, 'user_id' => auth()->user()->uuid, 'registration_number' => '']);
                        $isVehicleEdited = $this->vehicleService->createOrUpdateVehicle($request->except(['_token']),$vehicleData->id);
                        $message = $isUserUpdated ? "Profile updated successfully" : "Profile not updated";
                        DB::commit();
                        return $this->responseJson(true, 200, $message, new DriverResource(auth()->user()->fresh()));
                    }
                    break;

                case 'second':
                    $request->merge(['uuid' => auth()->user()->uuid, 'is_aadhar_approve' => 0, 'is_licence_approve' => 0, 'registration_step' => 2]);
                    $isUserUpdated = $this->userService->updateUser($request->except(['_token']), $user_id);
                    $message = $isUserUpdated ? "Profile updated successfully" : "Profile not updated";
                    DB::commit();
                    return $this->responseJson(true, 200, $message, new DriverResource(auth()->user()->fresh()));
                    break;

                case 'third':
                    // dd($request->all());
                    $request->merge(['registration_step' => 3, 'is_registered' => 1]);
                    $isUserUpdated = $this->userService->updateUser($request->only(['registration_step', 'role', 'is_branding', 'is_registered']), $user_id);
                    $request->merge(['user_id' => auth()->user()->uuid]);
                    $vehicleData = auth()->user()->vehicle ?? auth()->user()->vehicle()->create(['is_active' => false]);
                    $vehicleTypeData = $this->categoryService->findCategoryById($vehicleData->category_id);
                    $request->merge(['category_id' => $vehicleTypeData->uuid]);
                    if($vehicleData->sub_category_id){
                        $vehicleSubTypeData = $this->categoryService->findCategoryById($vehicleData->sub_category_id);
                        $request->merge(['sub_category_id' => $vehicleSubTypeData->uuid]);
                    }
                    if($vehicleData->body_type_id){
                        $vehicleBodyTypeData = $this->categoryService->findCategoryById($vehicleData->body_type_id);
                        $request->merge(['body_type_id' => $vehicleBodyTypeData->uuid]);
                    }

                    $isVehicleEdited = $this->vehicleService->createOrUpdateVehicle($request->except(['_token']),$vehicleData->id);
                    //dd($isVehicleEdited);
                    $notiTitle = "Welcome to Da'Ride";
                    $notiMessage = "Congratulations! Your registration has been successful.";
                    $data= [
                        'type' => 'newDriverRegistration',
                        'title' => $notiTitle,
                        'message' => $notiMessage,
                    ];
                    auth()->user()->notify(new SiteNotification(auth()->user(), $data));

                    if(auth()->user()->fcm_token){
                        auth()->user()->notify(new SendPushNotification($notiTitle,$notiMessage,[auth()->user()->fcm_token]));
                    }

                    if($request->is_branding){
                        $this->userService->addBrandingHistory([
                            "sender_id"=> $user_id,
                            "comment"=> "Requested for DaRide branding",
                            "status"=> 1,
                        ]);
                    }

                    $message = $isVehicleEdited ? "Vehicle updated successfully" : "Vehicle not updated";
                    DB::commit();
                    return $this->responseJson(true, 200, $message, new DriverResource(auth()->user()->fresh()));
                    break;
                default:
                    return $this->responseJson(false, 400, 'Bad Request', []);
                    break;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function getDriverProfileInfo()
    {
        try {
            $userDetails = auth()->user();

            $message = $userDetails ? "Profile found successfully" : "Profile not found";
            return $this->responseJson(true, 200, $message, new DriverProfileResource($userDetails));

        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something went wrong", (object)[]);
        }
    }
    public function updateDriverProfileInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            // 'aadhar_front' => 'required',
            // 'aadhar_back' => 'required',
            // 'licence_front' => 'required',
            // 'licence_back' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), []);
        }
        DB::beginTransaction();
        $request->merge(['role' => 'driver']);
        try {
            $nameArr = explode(' ', $request->name);
            $firstName = $nameArr[0];
            $lastName = (count($nameArr) > 1) ? $nameArr[1] : '';
            $request->merge(['first_name' => $firstName, 'last_name' => $lastName]);
            $isUserUpdated = $this->userService->updateUser($request->except(['_token', 'name']), auth()->user()->id);
            $message = $isUserUpdated ? "Profile updated successfully" : "Profile not updated";
            DB::commit();
            return $this->responseJson(true, 200, $message, new DriverProfileResource(auth()->user()->fresh()));
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function getWalletInfo()
    {
        $isWalletInfo = auth()->user()->wallet ? new WalletResource(auth()->user()->wallet) : (object)[];
        $message = auth()->user()->wallet ? "Wallet info found successfully" : "Wallet info not found";
        return $this->responseJson(true, 200, $message, $isWalletInfo);
    }
    public function applyForBranding(Request $request)
    {
        DB::beginTransaction();
        $request->merge(['is_branding' => 1]);
        try {
            switch(auth()->user()->is_branding){
                case 0:
                case 3:
                    $data = $this->userService->update($request->except(['_token']), auth()->user()->id);
                    $message = $data ? "DaRide branding request successfully applied" : "Something wrong happened";
                    if($data){
                        $this->userService->addBrandingHistory([
                            "sender_id"=> auth()->user()->id,
                            "comment"=> "Requested for DaRide branding",
                            "status"=> 1,
                        ]);
                    }

                    /*$mailData = [
                        'to' => getSiteSetting('site_email'),
                        'from' => env('MAIL_FROM_ADDRESS'),
                        'mail_type' => 'general',
                        'line' => auth()->user()->full_name.' has been applied for DaRide Branding.',
                        'content' => 'Please check and approve the Branding request.',
                        'subject' => auth()->user()->full_name.' applied for DaRide Branding',
                        'greetings' => 'Hello Sir/Madam',
                        'end_greetings' => 'Regards,',
                        'from_user' => env('MAIL_FROM_NAME')
                    ];
                    Mail::send(new SendMailable($mailData));*/
                    DB::commit();
                    break;
                case 1:
                    $message = "DaRide branding request already applied";
                    break;
                case 2:
                    $message = "DaRide branding request already accepted";
                    break;
            }
            return $this->responseJson(true, 200, $message);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
    public function rechargeWallet(Request $request)
    {
        $userData = auth()->user();
        $validator = Validator::make($request->all(), [
            'amount'=> 'required|numeric'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), []);
        }
        DB::beginTransaction();
        try {
            $siteCommissionPercentage = getSiteSetting('site_commission_percentage');
            $rechargeAmount = $siteCommissionPercentage * $request->amount;
            $isWalletUpdated = !$userData->wallet()->exists() ? $userData->wallet()->create(['balance'=>$rechargeAmount]) : $userData->wallet->increment('balance',$rechargeAmount) ;
            if ($isWalletUpdated) {
                $isTransactionCreated = $userData->wallet->transactions()->create([
                    'user_id'               => $userData->id,
                    'amount'                => $request->amount,
                    'status'                => 1,
                    'type'                  => 'credit',
                    'currency'              => '₹'
                ]);
                if ($isTransactionCreated) {

                    DB::commit();
                    return $this->responseJson(true, 200, 'Wallet updated successfully', []);
                    //return $this->responseJson(true, 200, 'Wallet updated successfully', new WalletResource(auth()->user()->wallet));
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function getBrandingHelpText()
    {
        $data = getSiteSetting('branding_details');
        return $this->responseJson(true, 200, 'Branding details found successfully', $data);
    }

    public function getNotifications(){
        $notifications=auth()->user()->notifications()->get();
        return $this->responseJson(true,200,'Notifications found successfully',NotificationResource::collection($notifications));
    }
    /*public function readNotifications(Request $request){
        if($request->has('id')){
            auth()->user()->unreadNotifications->where('id',$request->id)->markAsRead();
        }else{
            auth()->user()->unreadNotifications->markAsRead();
        }
        $notifications= auth()->user()->notifications()->get();
        return $this->responseJson(true,200,'Notifications found succesfully',NotificationResource::collection($notifications));
    }
    public function delteNotification(Request $request){
        $isNotificationDeleted= auth()->user()->notifications()->where('id',$request->id)->delete();
        $message= $isNotificationDeleted ? 'Notification deleted successfully' : 'Notification delete unscessfull';
        $notifications= auth()->user()->notifications()->get();
        return $this->responseJson(true,200,$message,NotificationResource::collection($notifications));
    }*/
    public function deleteAccount(Request $request){
        if(auth()->user()->hasRole('driver')){
            $data = auth()->user()->delete();
            if($data){
                $token = $request->user()->token();
                if ($token->revoke()) {
                    return $this->responseJson(true, 200, 'User successfully deleted',[]);
                }
            }
        }else{
            return $this->responseJson(false, 401, 'Unauthorize access', []);
        }
        return $this->responseJson(false, 500, 'Something went wrong', []);
    }

    public function setOnlineStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            // echo auth()->user()->id;
            // dd($request->all());
            $data = $this->userService->update($request->only(['is_online']), auth()->user()->id);
            $message = $request->is_online ? "You are now online" : "You are now offline";
            if($data){
                DB::commit();
            //     $this->userService->addBrandingHistory([
            //         "sender_id"=> auth()->user()->id,
            //         "comment"=> "Requested for DaRide branding",
            //         "status"=> 1,
            //     ]);
            }
            return $this->responseJson(true, 200, $message);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}
