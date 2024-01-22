<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Validator;

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
            $verificationCode = generateOtp();
            if($isUser){
                if ($isUser->hasRole('customer')) {

                    $isUserUpdated = $isUser->update(['verification_code' => $verificationCode]);
                    if($isUserUpdated){

                        $data = ['otp' => $verificationCode];
                        return $this->responseJson(true, 200, "Otp sent successfully", $data);
                    }
                }else{
                    return $this->responseJson(false, 200, 'Sorry you are not a user', (object)[]);
                }
            }else{
                $isUserCreated = $this->userService->createUser([
                    'mobile_number' => $request->phone,
                    'verification_code' => $verificationCode,
                    'is_active' => true,
                    'is_approve' => true,
                    'is_blocked' => false,
                    'role' => 'customer',
                ]);
                if($isUserCreated){

                    $data = ['otp' => $verificationCode];
                    return $this->responseJson(true, 200, "Otp sent successfully", $data);
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something Went Wrong", (object)[]);
        }
    }

    public function driverLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first(), (object)[]);
        }

        try {
            $isUser = $this->userService->findUserBy(['mobile_number' => $request->phone]);
            $verificationCode = generateOtp();
            if($isUser){
                if ($isUser->hasRole('driver')) {

                    $isUserUpdated = $isUser->update(['verification_code' => $verificationCode]);
                    if($isUserUpdated){
                        // $text = "Your Da'Ride Driver App Verification Otp is ".$verificationCode;
                        // $smsResponse = sendSms($request->phone, $text);
                        //dd($smsResponse);

                        $data = ['otp' => $verificationCode];
                        return $this->responseJson(true, 200, "Otp sent successfully", $data);
                    }
                }else{
                    return $this->responseJson(false, 200, 'Sorry you are not a user', (object)[]);
                }
            }else{
                $isUserCreated = $this->userService->createUser([
                    'mobile_number' => $request->phone,
                    'verification_code' => $verificationCode,
                    'is_active' => true,
                    'is_approve' => true,
                    'is_blocked' => false,
                    'role' => 'driver',
                ]);
                if($isUserCreated){
                    $data = ['otp' => $verificationCode];
                    return $this->responseJson(true, 200, "Otp sent successfully", $data);
                }
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something Went Wrong", (object)[]);
        }
    }
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|exists:users,mobile_number',
            'otp' => 'required|numeric|exists:users,verification_code',
        ]);
        if ($validator->fails()) return $this->responseJson(false, 200, $validator->errors()->first(), (object)[]);
        try {
            $user= User::where('mobile_number', $request->phone)->where('verification_code', $request->otp)->first();
            if($user != null){
                if(is_null($user->mobile_number_verified_at)){
                    $user->update([
                        'mobile_number_verified_at'=>Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                return $this->responseJson(true, 200, "OTP verified successfully",new UserResource($user));
            }else{
                return $this->responseJson(false, 200, "Please enter a valid OTP",(object)[]);
            }
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something Went Wrong", (object)[]);
        }
    }


    public function logout(Request $request)
    {
        $user = $request->user()->token();
        if ($user->revoke()) {
            $request->user()->update([
                'is_online' => 0
            ]);
            // cache()->forget('user-online' . $request->user()->id);
            return $this->responseJson(true, 200, 'User logged out successfully', []);
        }
        return $this->responseJson(false, 400, 'Something went wrong', []);
    }

    // public function getForgetOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'mobile_number' => 'numeric|exists:users,mobile_number'
    //     ]);
    //     if ($validator->fails()) {
    //         return $this->responseJson(false, 422, $validator->errors()->all(), "");
    //     }
    //     $mobileNumber = $request->mobile_number;
    //     $user  =  $this->userService->findOne(['mobile_number' => $mobileNumber, 'is_active' => 1]);
    //     if (!empty($user)) {
    //         return $this->responseJson(true, 200, 'User Details found', ['otp' => genrateOtp(4)]);
    //     }
    //     return $this->responseJson(false, 400, 'User not found', []);
    // }

    // public function resetPassword(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'mobile_number' => 'numeric|exists:users,mobile_number',
    //         'is_otp_verified' => 'required|boolean|in:1',
    //         'password' => 'required|min:8|string|confirmed'
    //     ]);
    //     if ($validator->fails()) {
    //         return $this->responseJson(false, 422, $validator->errors()->all(), "");
    //     }
    //     DB::beginTransaction();
    //     try {
    //         $user  =  $this->userService->findOne(['mobile_number' => $request->mobile_number, 'is_active' => 1]);
    //         $userPasswordUpdate  =  $this->userService->basicUpdate(['password' => bcrypt($request->password)], $user->id);
    //         if ($userPasswordUpdate) {
    //             DB::commit();
    //             return $this->responseJson(true, 200, 'Password reset successfully', []);
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }

    // public function changePassword(Request $request)
    // {
    //     $user = auth()->user();
    //     $validator = Validator::make($request->all(), [
    //         'current_password' => ['required', function ($value, $fail) use ($user) {
    //             if (!Hash::check($value, $user->password)) {
    //                 return $fail(__('The current password is incorrect.'));
    //             }
    //         }],
    //         'new_password' => 'required|string|min:6'
    //     ]);
    //     if ($validator->fails()) {
    //         return $this->responseJson(false, 422, $validator->errors()->all(), "");
    //     }
    //     DB::beginTransaction();
    //     try {
    //         $password = bcrypt($request->new_password);
    //         $isUserPasswordUpdated = auth()->user()->update([
    //             'password' => $password
    //         ]);
    //         if ($isUserPasswordUpdated) {
    //             DB::commit();
    //             return $this->responseJson(true, 200, 'Password Changed Successfully', new UserResource(auth()->user()));
    //         }
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
    //         return $this->responseJson(false, 500, $e->getMessage(), []);
    //     }
    // }


    public function module(Request $request)
    {
        try {
            $module = Module::all();
            if (!empty($module)) {
                return $this->responseJson(true, 200, 'Data Found', ModuleResource::collection($module));
            } else {
                return $this->responseJson(true, 200, 'Data not Found', []);
            }
            // dd($module->toArray());
        } catch (\Throwable $e) {
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function applicationForm(Request $request)
    {
        try {
            $ApplicationForm = ApplicationForm::all();
            // dd($ApplicationForm);
            if (!empty($ApplicationForm)) {
                return $this->responseJson(true, 200, 'Data Found', ApplicationFormResource::collection($ApplicationForm));
            } else {
                return $this->responseJson(true, 200, 'Data not Found', []);
            }
            // dd($module->toArray());
        } catch (\Throwable $e) {
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }


    public function categoryList(Request $request){
        try {
            $category = Category::all();
            if($category){
                return $this->responseJson(true, 200, 'Data Found', CategoryResource::collection($category));
            }else{
                return $this->responseJson(true, 200, 'No Data Found', []);
            }
        } catch (\Throwable $e) {
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
        // dd($category->toArray());
    }
}
