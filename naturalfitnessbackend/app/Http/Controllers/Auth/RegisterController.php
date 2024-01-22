<?php

namespace App\Http\Controllers\Auth;

//use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Services\User\UserEnquiryService;
use App\Http\Controllers\BaseController;

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
    public function __construct(protected UserService $userService, protected UserEnquiryService $userEnquiryService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
        $this->userEnquiryService = $userEnquiryService;
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
    public function createAccount(Request $request, $uuid = '')
    {
        $this->setPageTitle('Create Account');
        if ($request->post()) {
            DB::beginTransaction();
            try {
                $request->validate([
                        'first_name' => 'required|string|min:1',
                        'last_name' => 'required|string|min:1',
                        'role' => 'required|string|in:'.$request->role,
                        'email' => 'required|email|unique:users,email',
                        'mobile_number' => 'required|numeric|min:1000000000|unique:users,mobile_number',
                        'recaptcha'=> ['required',new RecaptchaRule('register')]
                ]);
                $request->merge(['password' => bcrypt($request->mobile_number)]);
                $isUserCreated = $this->userService->createUser($request->except(['_token', 'enquiryUuid']));
                if ($isUserCreated) {
                    if($request->enquiryUuid){
                        $userId = $isUserCreated->id;
                        $enquiryId = uuidtoid($request->enquiryUuid, 'user_enquiries');
                        $userEnquiryData = $this->userEnquiryService->find($enquiryId);

                        if($userEnquiryData){
                            $isEnquiryUpdated = $userEnquiryData->update(['user_id'=>$userId]);
                        }
                    }
                    DB::commit();
                    return $this->responseRedirect('frontend.congrats', 'Account Created Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack($e->getMessage(), 'error', true, true);
            }
        }
        return view('auth.create-account', compact('uuid'));
    }

    public function deleteAccount(Request $request){
        if($request->post()){
            return $this->responseRedirectBack('Your request submitted successfully','success');
        }
        return view('auth.account-delete');
    }
}
