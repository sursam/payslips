<?php

namespace App\Http\Controllers\Auth;

use App\Models\User\User;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::MAIN;

    protected function redirectTo()
    {
        if (auth()->user()->hasRole('admin')) {
            return route('admin.home');
        }else if (auth()->user()->hasRole('customer')) {
            return route('customer.home');
        }else if (auth()->user()->hasRole('council')) {
            return route('council.home');
        }else if (auth()->user()->hasRole('agent')) {
            return route('agent.home');
        }

        return RouteServiceProvider::MAIN;
    }

    public function adminResetPassword(Request $request)
    {
        $this->setPageTitle('Reset Password');
        $token = $request->route()->parameter('token');

        return view('auth.admin.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );

    }

    public function submitAdminResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'recaptcha'=> ['required',new RecaptchaRule('change')]
        ]);

        $isTokenFound = DB::table('password_resets')
                            ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                            ])
                            ->first();

        if(!$isTokenFound){
            return $this->responseRedirectBack('Invalid token!', 'error', true, true);
        }

        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        
        return $this->responseRedirect('admin.login', 'Your password has been changed', 'success');
    }
}
