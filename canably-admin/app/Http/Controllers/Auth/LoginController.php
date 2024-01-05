<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('guest')->except('logout', 'adminLogout');
    }

    public function showAdminLoginForm()
    {
        $this->setPageTitle('Login', '');
        return view('auth.login');
    }
    public function showLoginForm()
    {
        $this->setPageTitle('Login', '');
        if (str_contains(request()->headers->get('referer'), 'cart')) {
            session()->put('cartUrl', 'cart');
        }
        return view('auth.customer.login');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            // 'recaptcha' => ['required', new ReCaptchaRule('login')],
        ]);

        $userData = array(
            'email' => $input['email'],
            'password' => $input['password'],
        );
        $rememberMe = $request->has('remember') ? true : false;

        if (auth()->attempt($userData, $rememberMe)) {
            $user = auth()->user();
            if (auth()->user()->is_twofactor) {
                $user->generateTwoFactorCode();
                $user->notify(new \App\Notifications\TwoFactorCode());
                return redirect()->intended(route('twofactor'));
            } else {
                if(is_null(auth()->user()->email_verified_at)){
                    auth()->logout();
                    return $this->responseRedirectBack('Please Verify your mail first before you login', 'info', true, true);
                }
                if (!auth()->user()->is_active) {
                    auth()->logout();
                    return $this->responseRedirectBack('Oh no! Your Account has been deactivated. Please contact admin', 'info', true, true);
                } elseif (!auth()->user()->is_approve) {
                    auth()->logout();
                    return $this->responseRedirectBack('Hang tight! Our team are currently verifying your application. You\'ll receive an approval email when your account is ready.', 'info', true, true);
                } else {
                    $referer = $request->headers->get('referer');
                    if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('sub-admin')) {
                        if (!str_contains($referer, 'admin')) {
                            auth()->logout();
                            return $this->responseRedirectBack('Sorry You are not allowed to login from here', 'info', true, true);
                        }
                        return redirect(RouteServiceProvider::HOME);
                    } elseif (auth()->user()->hasRole('customer')) {
                        if (str_contains($referer, 'admin')) {
                            auth()->logout();
                            return $this->responseRedirectBack('Sorry You are not allowed to login from here', 'info', true, true);
                        }
                        if (session()->has('cartUrl')) {
                            return redirect()->route('frontend.cart');
                        }
                        return redirect()->route('customer.dashboard');
                    } else if (auth()->user()->hasRole('seller')) {
                        return redirect()->route('seller.dashbord');
                    } else if (auth()->user()->hasRole('delivery-agent')) {
                        return redirect()->route('delivery.agent.dashbord');
                    }

                }
            }
        }

        return $this->responseRedirectBack('Email address and password are wrong.', 'error', true, true);
    }

    public function adminLogout(Request $request)
    {
        $this->loggedOut($request);
    }

    protected function loggedOut(Request $request)
    {
        $referer = $request->headers->get('referer');
        if (str_contains($referer, 'admin')) {
            return redirect('/admin/login');
        } else {
            return redirect('/login');
        }

    }
}
