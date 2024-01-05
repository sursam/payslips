<?php

namespace App\Http\Controllers\Api;

use App\Mail\SendMailable;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    protected $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all());
        }
        if (!auth()->attempt($request->only(['email', 'password']))) {
            return $this->responseJson(false, 200, 'Incorrect Details. Please try again', []);
        }
        if (!auth()->user()->hasRole('delivery-agent')) {
            auth()->logout();
            return $this->responseJson(false, 200, 'Sorry you are not a delivery agent', []);
        }

        if (!auth()->user()->is_approve) {
            auth()->logout();
            return $this->responseJson(false, 200, 'Your account is not approved yet. Please contact admin', []);
        }
        if (!auth()->user()->is_active) {
            auth()->logout();
            return $this->responseJson(false, 200, 'Your account has been deactivated. Please contact admin', []);
        }
        if (auth()->user()->is_blocked) {
            auth()->logout();
            return $this->responseJson(false, 200, 'Your account has been blocked. Please contact admin', []);
        }

        $user = auth()->user();
        return $this->responseJson(true, 200, 'Login successfull', new UserResource($user));
    }


    public function getForgetOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'email' =>'required|email|exists:users,email',
        ]);
        if ($validator->fails()) { return $this->responseJson(false, 422, $validator->errors()->all()); }
        DB::beginTransaction();
        try {
            $user = $this->userService->findUserBy($request->only('email'));
            $otp = random_int(1000, 9999);
            $isUserUpdated= $user->update(['verification_code' => $otp]);
            if ($isUserUpdated) {
                DB::commit();
                $mailParams                     = array();
                $mailParams['mail_type']        = 'agent_forget_password';
                $mailParams['to']               = $user->email;
                $mailParams['from']             = config('mail.from.address');
                $mailParams['subject']          = 'OTP for forget password';
                $mailParams['greetings']        = "Hello ! User";
                $mailParams['line']             = 'Please use this otp for verify the action';
                $mailParams['otp']             = $user->verification_code;
                $mailParams['end_greetings']    = "Regards,";
                $mailParams['from_user']        = env('MAIL_FROM_NAME');
                Mail::send(new SendMailable($mailParams));
                return $this->responseJson(true, 200, 'OTP sent successfully', ['otp'=>$user->verification_code]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, "Something went wrong");
        }

    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|string|confirmed'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }
        DB::beginTransaction();
        try {
            $user  =  $this->userService->findUserBy(['email' => $request->email, 'is_active' => 1]);
            $userPasswordUpdate  =  $this->userService->updateUserStatus(['password' => bcrypt($request->password)], $user->id);
            if ($userPasswordUpdate) {
                DB::commit();
                return $this->responseJson(true, 200, 'Password reset successfully', []);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'new_password' => 'required|string|min:6'
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }
        DB::beginTransaction();
        try {
            $password = bcrypt($request->new_password);
            $isUserPasswordUpdated = auth()->user()->update([
                'password' => $password
            ]);
            if ($isUserPasswordUpdated) {
                DB::commit();
                return $this->responseJson(true, 200,'Password Changed Successfully', new UserResource(auth()->user()));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }

    public function logout(Request $request)
    {
        $request->headers->set('accept', 'application/json');
        try {
            $token = auth()->user()->token();
            $token->revoke();
            return $this->responseJson(true, 200, "You have been successfully logged out!");
        } catch (\Exception $e) {
            return $this->responseJson(false, 500, "Something went wrong");
        }
    }
}
