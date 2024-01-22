<?php

namespace App\Http\Controllers\Api\Driver;

use Carbon\Carbon;
// use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Services\User\UserService;
// use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
// use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\DriverResource;

class AuthController extends BaseController
{
    public function __construct(protected UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first(), (object)[]);
        }

        try {
            $isUser = $this->userService->findUserBy(['mobile_number' => $request->phone]);
            if($request->phone == config('services.apple.phone_no')){
                $verificationCode = config('services.apple.otp');
            }elseif($request->phone == config('services.google.phone_no')){
                $verificationCode = config('services.google.otp');
            }else{
                $verificationCode = generateOtp();
            }

            $text = getSiteSetting('driver_login_otp_template') ? getSiteSetting('driver_login_otp_template') : "Your%20Da%27Ride%20Driver%20App%20Verification%20Otp%20is%20{CODE}.%20Thank%20you.";
            $text = str_replace('{CODE}',$verificationCode,$text);
            // dd($text);
            if($isUser){
                if ($isUser->hasRole('driver')) {
                    if ($isUser->is_active) {
                        $isUserUpdated = $isUser->update(['verification_code' => $verificationCode]);
                        if($isUserUpdated){
                            //$text = "Your DaRide Driver App Verification Otp is ".$verificationCode.".%20Thank%20you.";
                            $smsResponse = sendSms($request->phone, $text);
                            if($smsResponse->ok()){
                                // dd($smsResponse->body());
                                $data = ['otp' => $verificationCode];
                                return $this->responseJson(true, 200, "Otp sent successfully", $data);
                            }
                        }
                    }else{
                        return $this->responseJson(false, 200, 'Sorry your account has been suspended', (object)[]);
                    }
                }else{
                    return $this->responseJson(false, 200, 'Sorry you are not a driver', (object)[]);
                }
            }else{
                $isUserCreated = $this->userService->createUser([
                    'mobile_number' => $request->phone,
                    'verification_code' => $verificationCode,
                    'is_active' => true,
                    'is_approve' => false,
                    'is_blocked' => false,
                    'role' => 'driver',
                ]);
                if($isUserCreated){
                    $smsResponse = sendSms($request->phone, $text);
                    if($smsResponse->ok()){
                        $data = ['otp' => $verificationCode];
                        return $this->responseJson(true, 200, "Otp sent successfully", $data);
                    }
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something Went Wrong", (object)[]);
        }
    }
    public function verifyDriverOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|exists:users,mobile_number',
            'otp' => 'required|numeric|exists:users,verification_code',
        ]);
        if ($validator->fails()) return $this->responseJson(false, 200, $validator->errors()->first(), (object)[]);
        try {
            $user = $this->userService->findUserBy(['mobile_number' => $request->phone, 'verification_code' => $request->otp]);
            // $user= User::where('mobile_number', $request->phone)->where('verification_code', $request->otp)->first();
            if($user){
                $dataToUpdate = [
                    'last_login_at' => Carbon::now()->format('Y-m-d H:i:s')
                ];
                if($request->fcm_token){
                    $dataToUpdate['fcm_token'] = $request->fcm_token;
                }
                // $inactivity_time = getSiteSetting('inactivity_time') ? getSiteSetting('inactivity_time') : 1200;
                // $expires_after = Carbon::now()->addSeconds($inactivity_time);
                // cache()->put('user-online' . $user->id, true, $expires_after);                
                if(is_null($user->mobile_number_verified_at)){
                    $dataToUpdate['mobile_number_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');
                }
                $user->update($dataToUpdate);
                return $this->responseJson(true, 200, "OTP verified successfully",new DriverResource($user));
            }else{
                return $this->responseJson(false, 200, "Please enter a valid OTP",(object)[]);
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something Went Wrong", (object)[]);
        }
    }
}
