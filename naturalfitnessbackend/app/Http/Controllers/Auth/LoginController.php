<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function adminLogin()
    {
        $this->setPageTitle('Login');
        return view('auth.admin.login');
    }
    public function councilLogin()
    {
        $this->setPageTitle('Login');
        return view('auth.council.login');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            // 'recaptcha' => ['required', new RecaptchaRule('loginOrRegister')],
        ]);
        $userData = array(
            'email' => $input['email'],
            'password' => $input['password'],
        );

        $rememberMe = $request->has('remember') ? true : false;
        if (auth()->attempt($userData, $rememberMe)) {
            // dd('hgere');
            $user = auth()->user();
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp(),
            ]);

            if (auth()->user()->is_twofactor) {
                $user->generateTwoFactorCode();
                $user->notify(new TwoFactorCode());

                return redirect()->intended(route('twofactor'));
            } else {
                if (!auth()->user()->is_active) {
                    auth()->logout();
                    return $this->responseRedirectBack('Oh no! Your Account has been deactivated. Please contact admin', 'info', true, true);
                }
                if (!auth()->user()->is_approve) {
                    auth()->logout();
                    return $this->responseRedirectBack('Oh no! Your Account has been unapproved. Please contact admin', 'warning', true, true);
                }
                if (auth()->user()->is_blocked) {
                    auth()->logout();
                    return $this->responseRedirectBack('Oh no! Your Account has been blocked. Please contact admin', 'warning', true, true);
                }
                if (auth()->user()->hasRole('super-admin')) {
                    if(!auth()->user()->can('view-dashboard')){
                        return redirect()->intended(route('admin.profile'));
                    }
                    return redirect()->intended(route('admin.home'));
                }
                if(auth()->user()->hasRole('customer')){
                    if(!auth()->user()->can('view-dashboard')){
                        return redirect()->intended(route('customer.profile'));
                    }
                    return redirect()->intended(route('customer.home'));
                }
                if(auth()->user()->hasRole('council')){
                    if(!auth()->user()->can('view-dashboard')){
                        return redirect()->intended(route('council.profile'));
                    }
                    return redirect()->intended(route('council.home'));
                }
            }
        }
        return $this->responseRedirectBack('Email address and password are wrong.', 'error', true, true);
    }

    protected function loggedOut(Request $request) {
        return redirect('/login');
    }


}
