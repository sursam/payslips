<?php

namespace App\Http\Controllers\Auth;


use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Services\User\InviteService;
use Illuminate\Support\Facades\Hash;
use App\Events\SiteNotificationEvent;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * @var UserService
     */
    protected $userService;
    public function __construct(InviteService $inviteService, UserService $userService)
    {
        $this->middleware('guest');
        $this->inviteService = $inviteService;
        $this->userService = $userService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Displays admin register form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        $invitationToken = $request->get('invitation_token');
        $invitation = $this->inviteService->findInviteOrFail(['invitation_token' => $invitationToken]);
        $email = $invitation->email;
        $id = $invitation->id;
        $this->setPageTitle('Invite Admin');
        return view('auth.customer.register', compact('email', 'id', 'invitationToken'));
    }

    /**
     * Register a new admin
     *
     * @param $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function register(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'between:6,20',
                'regex:/(^([a-zA-Z0-9_.@]+)(\d+)?$)/u',
                'unique:users',
            ],
            'email' => 'required|email|max:255|unique:users|exists:invitations,email',
            'password' => 'required|min:8|confirmed',
            'invitation_id' => 'required|numeric',
            'invitation_token' => 'required|string|exists:invitations,invitation_token',
        ]);

        if ($validated) {
            try
            {
                DB::beginTransaction();
                $id = $request->invitation_id;
                $invitationToken = $request->invitation_token;
                $email = $request->email;

                $invitation = $this->inviteService->findInviteOrFail([
                    'id' => $id,
                    'invitation_token' => $invitationToken,
                    'email' => $email,
                    'registered_at' => null,
                ]);

                if ($invitation) {
                    $params = $request->except('_token');
                    $params['role_id'] = $invitation->role_id;

                    $user = $this->userService->createAdmin($params);
                    if ($user) {DB::commit();
                        $invitation->registered_at = $user->created_at;
                        $invitation->save();
                        return redirect(route('login'))->with('Your account has been successfully created, Please login to continue', 'success', false, false);
                    } else {
                        DB::rollBack();
                        return redirect(route('login'))->with('Something went wrong when creating your account, Please try again!!!', 'error', true, true);
                    }
                } else {
                    return redirect(route('login'))->with('Please login with registered email id and password!!!', 'error', true, true);
                }
            } catch (\Exception$exception) {
                DB::rollBack();

                return false;
            }
        }
    }

    public function registration(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email|unique:users',
                'privacypolicy' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $password = Str::random(6);
                $request->merge(['password'=>Hash::make($password)]);
                $user = $this->usersDetailsSave($request);
                $id = $user->id;
                if ($id) {
                    DB::commit();
                    event(new Registered($user));
                    return $this->responseRedirect('login', 'Registration successful. Check Your email for verification', 'success', false, false);
                } else {
                    DB::rollBack();
                    return $this->responseRedirectBack('We are facing some technical problem now. Please try again after some time.', 'error', true, true);
                }
            } catch (\Exception$e) {
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                DB::rollBack();
                return $this->responseRedirectBack('We are facing some technical problem now. Please try again after some time.', 'error', true, true);
            }
        }
        $this->setPageTitle('Registration', '');
        return view('auth.customer.register');
    }

    private function usersDetailsSave($request)
    {
        if ($request->isMethod('post')) {
            $userUUID = '';
            $request->merge(['registration_ip' => $request->ip(),'is_active'=>true,'is_approve'=>true]);
            return $this->userService->registerCustomer($request->except('_token'));
        }
    }
    public function sendVerificationEmail(Request $request)
    {
        $userUUID = $request->userUuid;
        $userId = uuidtoid($userUUID, 'users');
        if ($userId) {
            $user = $this->userService->findUser($userId);
            if ($user) {
                $user->sendEmailVerificationNotification();
                return true;
            }
        }
        return false;
    }
}
