<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    use AuthenticatesUsers, ThrottlesLogins; // Import traits

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $maxAttempts = 5; // Default is 5
    protected $decayMinutes = 2; // Default is 1
    // protected $lockoutTime = 120;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('throttle:'.$this->maxAttempts.','.$this->decayMinutes)->only('login');
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

    protected function throttleKey(Request $request)
    {
        if (config('auth.throttle_key') == 'username') {
            return $request->email;
        }else if (config('auth.throttle_key') == 'ip') {
            return $request->ip();
        }else {
            return Str::lower($request->input($this->username())).'|'.$request->ip();
        }
    }

    /*public function login(Request $request)
    {
        // Increment login attempts if failed
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $input = $request->all();
        // dd($input);
        if($request->password=='' && $request->email=='')
        return $this->responseJson(false, 200, 'Email address & Password is required.', [
        'redirect_url' => route('login')
        ]);
        if($request->email=='')
            return $this->responseJson(false, 200, 'Email address is required.', [
            'redirect_url' => route('login')
        ]);
        if($request->password=='')
            return $this->responseJson(false, 200, 'Password is required.', [
            'redirect_url' => route('login')
        ]);
        $this->validate($request, [
            'email' => 'email',
            //'password' => 'required',
            // 'recaptcha' => ['required', new RecaptchaRule('loginOrRegister')],
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email format is invalid',
            'password' => 'Password is required'
        ]);

        $userData = array(
            'email' => $input['email'],
            'password' => $input['password'],
        );

        $rememberMe = $request->has('remember') ? true : false;
        if (auth()->attempt($userData, $rememberMe)) {
            $this->clearLoginAttempts($request);

            $user = auth()->user();
            // $user->update([
            //     'last_login_at' => Carbon::now()->toDateTimeString(),
            //     'last_login_ip' => $request->getClientIp(),
            // ]);

            if (auth()->user()->is_twofactor) {
                $user->generateTwoFactorCode();
                $user->notify(new TwoFactorCode());

                // return redirect()->intended(route('twofactor'));
                return $this->responseJson(true, 200, 'Two factor.', [
                    'redirect_url' => route('twofactor')
                ]);
            } else {
                if (!auth()->user()->last_login_at) {
                    //return redirect()->route('admin.reset.user.password');
                    return $this->responseJson(true, 200, 'Please reset your password first.', [
                        'redirect_url' => route('admin.reset.user.password')
                    ]);
                }
                if (!auth()->user()->is_active) {
                    auth()->logout();
                    // return $this->responseRedirectBack('Oh no! Your Account has been deactivated. Please contact admin', 'info', true, true);
                    return $this->responseJson(false, 200, 'Oh no! Your Account has been deactivated. Please contact admin', [
                        'redirect_url' => route('login')
                    ]);
                }
                if (!auth()->user()->is_approve) {
                    auth()->logout();
                    // return $this->responseRedirectBack('Oh no! Your Account has been unapproved. Please contact admin', 'warning', true, true);
                    return $this->responseJson(false, 200, 'Oh no! Your Account has been unapproved. Please contact admin', [
                        'redirect_url' => route('login')
                    ]);
                }
                if (auth()->user()->is_blocked) {
                    auth()->logout();
                    // return $this->responseRedirectBack('Oh no! Your Account has been blocked. Please contact admin', 'warning', true, true);
                    return $this->responseJson(false, 200, 'Oh no! Your Account has been blocked. Please contact admin', [
                        'redirect_url' => route('login')
                    ]);
                }
                // if (auth()->user()->hasRole('super-admin')) {

                Auth::logoutOtherDevices($request->password);

                if(!auth()->user()->can('view-dashboard')){
                    // return redirect()->intended(route('admin.profile'));
                    return $this->responseJson(true, 200, 'Successfully logged in.', [
                        'redirect_url' => route('admin.profile')
                    ]);
                }
                // return redirect()->intended(route('admin.home'));
                return $this->responseJson(true, 200, 'Successfully logged in.', [
                    'redirect_url' => route('admin.home')
                ]);
                // }
            }
        }
        $this->incrementLoginAttempts($request);

        $nb_attempts_left = $this->limiter()->retriesLeft($this->throttleKey($request), $this->maxAttempts);
        $failed_message = $nb_attempts_left ? 'You have '.($nb_attempts_left > 1 ? 'attempts' : 'attempt').' left.' : 'Your account has been locked for '.$this->decayMinutes.' minutes';

        return $this->responseJson(false, 200, 'Email address and password are wrong. '.$failed_message, [
            'redirect_url' => route('login'),
            'failed_attempts' => $nb_attempts_left,
        ]);
    }*/

    public function login(Request $request)
    {
        $input = $request->all();
        // dd($input);
        if($request->password=='' && $request->email=='')
            return $this->responseJson(false, 200, 'Email address & Password is required.', [
                'redirect_url' => route('login')
            ]);
        if($request->email=='')
            return $this->responseJson(false, 200, 'Email address is required.', [
                'redirect_url' => route('login')
            ]);
        if($request->password=='')
            return $this->responseJson(false, 200, 'Password is required.', [
                'redirect_url' => route('login')
            ]);
        $this->validate($request, [
            'email' => 'email',
            //'password' => 'required',
            // 'recaptcha' => ['required', new RecaptchaRule('loginOrRegister')],
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email format is invalid',
            'password' => 'Password is required'
        ]);

        $userData = array(
            'email' => $input['email'],
            'password' => $input['password'],
        );

        $rememberMe = $request->has('remember') ? true : false;
        if (auth()->attempt($userData, $rememberMe)) {
            $key = $this->throttleKey($request);
            $rateLimiter = $this->limiter();
            $rateLimiter->clear($key);

            $user = auth()->user();
            // $user->update([
            //     'last_login_at' => Carbon::now()->toDateTimeString(),
            //     'last_login_ip' => $request->getClientIp(),
            // ]);

            if (auth()->user()->is_twofactor) {
                $user->generateTwoFactorCode();
                $user->notify(new TwoFactorCode());

                // return redirect()->intended(route('twofactor'));
                return $this->responseJson(true, 200, 'Two factor.', [
                    'redirect_url' => route('twofactor')
                ]);
            } else {
                if (!auth()->user()->last_login_at) {
                    //return redirect()->route('admin.reset.user.password');
                    return $this->responseJson(true, 200, 'Please reset your password first.', [
                        'redirect_url' => route('admin.reset.user.password')
                    ]);
                }
                if (!auth()->user()->is_active) {
                    auth()->logout();
                    // return $this->responseRedirectBack('Oh no! Your Account has been deactivated. Please contact admin', 'info', true, true);
                    return $this->responseJson(false, 200, 'Oh no! Your Account has been deactivated. Please contact admin', [
                        'redirect_url' => route('login')
                    ]);
                }
                if (!auth()->user()->is_approve) {
                    auth()->logout();
                    // return $this->responseRedirectBack('Oh no! Your Account has been unapproved. Please contact admin', 'warning', true, true);
                    return $this->responseJson(false, 200, 'Oh no! Your Account has been unapproved. Please contact admin', [
                        'redirect_url' => route('login')
                    ]);
                }
                if (auth()->user()->is_blocked) {
                    auth()->logout();
                    // return $this->responseRedirectBack('Oh no! Your Account has been blocked. Please contact admin', 'warning', true, true);
                    return $this->responseJson(false, 200, 'Oh no! Your Account has been blocked. Please contact admin', [
                        'redirect_url' => route('login')
                    ]);
                }
                // if (auth()->user()->hasRole('super-admin')) {

                Auth::logoutOtherDevices($request->password);

                if(!auth()->user()->can('view-dashboard')){
                    // return redirect()->intended(route('admin.profile'));
                    return $this->responseJson(true, 200, 'Successfully logged in.', [
                        'redirect_url' => route('admin.profile')
                    ]);
                }
                // return redirect()->intended(route('admin.home'));
                return $this->responseJson(true, 200, 'Successfully logged in.', [
                    'redirect_url' => route('admin.home')
                ]);
                // }
            }
        }else{
            if ($this->hasTooManyLoginAttempts($request)) {

                $key = $this->throttleKey($request);
                $rateLimiter = $this->limiter();

                $limit = [5 => 2];
                $attempts = $rateLimiter->attempts($key);  // return how attapts already yet

                // if($attempts >= 5)
                // {
                //     $rateLimiter->clear($key);;
                // }

                if(array_key_exists($attempts, $limit)){
                    $this->decayMinutes = $limit[$attempts];
                }

                $this->incrementLoginAttempts($request);

                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);

            }

            $this->incrementLoginAttempts($request);
            // return $this->sendFailedLoginResponse($request);
            $nb_attempts_left = $this->limiter()->retriesLeft($this->throttleKey($request), $this->maxAttempts);
            $failed_message = $nb_attempts_left ? 'You have '.($nb_attempts_left > 1 ? 'attempts' : 'attempt').' left.' : 'Your account has been locked for '.$this->decayMinutes.' minutes';

            return $this->responseJson(false, 200, 'These credentials do not match our records.. '.$failed_message, [
                'redirect_url' => route('login'),
                'failed_attempts' => $nb_attempts_left,
            ]);
        }
    }

    protected function loggedOut(Request $request) {
        return redirect('/login');
    }
}
