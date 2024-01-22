<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use App\Services\User\UserService;
use App\Services\Company\CompanyService;
use App\Services\Location\StateService;
use App\Models\Company\Service;
use App\Services\Product\ProductService;

class DashboardController extends BaseController
{
    public function __construct(protected UserService $userService, protected CompanyService $companyService, protected StateService $stateService, protected ProductService $productService)
    {
        $this->userService = $userService;
        $this->companyService= $companyService;
        $this->stateService= $stateService;
        $this->productService= $productService;
    }
    public function index(Request $request)
    {
        $userData = null;
        if(auth()->user()){
            $user = auth()->user();
            $userId = $user->id;
            $userData = $this->userService->findUserById($userId);
        }

        return view('customer.dashboard.index', compact('userData'));
    }
    public function profile(Request $request){
        $this->setPageTitle('My Profile');
        if($request->post()){
            $request->validate([
                'username'=> 'required|string|unique:users,username,'.auth()->user()->id,
                'first_name'=> 'required|string',
                'last_name'=> 'sometimes|string',
                'mobile_number'=> 'required|numeric|unique:users,mobile_number,'.auth()->user()->id,
                'gender'=> 'sometimes|string|in:male,female,other',
                'birthday'=> 'sometimes|nullable|date|date_format:Y-m-d'
            ]);
            DB::beginTransaction();
            try {
                $isUserUpdated= auth()->user()->update($request->only(['first_name','last_name','mobile_number']));
                if($isUserUpdated){
                    $isUserProfileUpdated = auth()->user()->profile()->update($request->only(['gender','birthday']));
                    if($isUserProfileUpdated){
                        DB::commit();
                        return $this->responseRedirectBack('Profile updated successfully','success', true, true);
                    }
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
                return $this->responseRedirectBack('Something went wrong','error', true, true);
            }
        }
        return view('customer.dashboard.profile');
    }
    public function changePassword(Request $request){
        $this->setPageTitle('Change password');
        if ($request->post()) {
            $user = auth()->user();
            $request->validate([
                'current_password' => ['required', function ($key,$value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }],
                'password' => 'required|string|min:6|different:current_password|confirmed'
            ]);

            DB::beginTransaction();
            try {
                $password = bcrypt($request->password);
                $isUserPasswordUpdated = $user->update([
                    'password' => $password
                ]);
                if ($isUserPasswordUpdated) {
                    DB::commit();
                    return $this->responseRedirectBack('Password Changed Successfully','success', true, true);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
                return $this->responseRedirectBack('Something went wrong','error', true, true);
            }
        }
        return view('customer.dashboard.change-password');
    }

    public function verifyCompanyProfile(Request $request)
    {
        $this->setPageTitle('Verify Company');
        $user = auth()->user();
        $userId = $user->id;
        $userData= $this->userService->findUserById($userId);
        $companyData= $userData->company ?? $userData->company()->create(['is_active' => false]);
        if ($request->post()) {
            $request->validate([
                'registration_number'=> 'required|string',
            ]);

            DB::beginTransaction();
            try {
                $request->merge(['is_registered'=>true]);
                $isCompanyEdited = $this->companyService->createOrUpdateCompany($request->except(['_token']),$companyData->id);
                if ($isCompanyEdited) {
                    DB::commit();
                    return $this->responseRedirectBack('Company Successfully Verified', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
    }

    public function companyProfile(Request $request)
    {
        $this->setPageTitle('Edit Company');
        $user = auth()->user();
        $userId = $user->id;
        $userData= $this->userService->findUserById($userId);
        $companyData = $userData->company ?? $userData->company()->create(['is_active' => false]);
        //dd($companyData->services);

        $states= $this->stateService->findStates(['country_id'=>207]);
        if ($request->post()) {
            DB::beginTransaction();
            try {
                if(!$companyData->is_registered){
                    $request->validate([
                        'registration_number'=> 'required|string',
                    ]);
                    $request->merge(['is_registered'=>true]);
                    $isCompanyEdited = $this->companyService->createOrUpdateCompany($request->except(['_token']),$companyData->id);
                    if ($isCompanyEdited) {
                        DB::commit();
                        return $this->responseRedirectBack('Company Successfully Verified', 'success', false);
                    }
                }else{
                    //dd($request->all());
                    $request->validate([
                        'registration_number'=> 'required|string',
                        'name'=> 'required|string',
                        'company_name'=> 'required|string',
                        'business_name'=> 'required|string',
                        'state_id'=> 'required|numeric',
                        'city_id'=> 'sometimes|numeric|nullable',
                        'zipcode'=> 'required|string',
                        'trading_address'=> 'required|string',
                        'registered_address'=> 'required|string',
                        'website'=> 'required|string',
                        'ownership'=> 'required|string',
                        'trade_started_at'=> 'required|nullable|date|date_format:Y-m-d',
                        'turnover'=> 'required|numeric',
                        'employeees'=> 'required|numeric',
                        'is_vat_registered'=> 'required|string|in:1,0',
                        'vat_no'=> 'required_if:is_vat_registered,1|string|nullable'
                    ]);
                    $request->merge(['country_id'=>207]);
                    $isCompanyEdited = $this->companyService->createOrUpdateCompany($request->except(['_token', 'services']),$companyData->id);
                    if ($isCompanyEdited) {
                        if($request->services){
                            Service::where('company_id', $companyData->id)->forceDelete();
                            foreach($request->services as $service){
                                $serviceData = $this->productService->createOrUpdateService(['company_id'=> $companyData->id, 'name'=>$service]);
                            }
                        }
                        DB::commit();
                        return $this->responseRedirectBack('Company Information Updated Successfully', 'success', false);
                    }
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }
        }
        return view('customer.company.profile',compact('companyData', 'userData', 'states'));
    }

    /*public function changePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'current_password' => ['required', function ($key, $value,$fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => 'required|string|min:6|different:current_password|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $password = bcrypt($request->password);
            $isUserPasswordUpdated = $user->update([
                'password' => $password,
            ]);
            if ($isUserPasswordUpdated) {
                DB::commit();
                return $this->responseRedirectBack('Password Changed Successfully', 'success');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseRedirectBack('Something went wrong', 'error');
        }
    }

    public function updateProfile(Request $request){
        $request->validate([
            'first_name'=> 'required|string',
            'last_name'=> 'sometimes|string',
            'username'=> 'required|string|unique:users,username,'.auth()->user()->id,
            'mobile_number'=> 'required|numeric|unique:users,mobile_number,'.auth()->user()->id
        ]);
        DB::beginTransaction();
        try {
            $isUserUpdated= auth()->user()->update($request->only(['first_name','last_name','mobile_number','username']));
            if($isUserUpdated){
                $isUserProfileUpdated= auth()->user()->profile()->update($request->only(['gender','birthday']));
                if($isUserProfileUpdated){
                    DB::commit();
                    return $this->responseRedirectBack('Profile updated successfully','success');
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
            return $this->responseRedirectBack('Something went wrong','error');
        }
    }*/


    public function notifications(Request $request)
    {
        return view('customer.dashboard.notifications');
    }
    public function support(Request $request)
    {
        return view('customer.dashboard.support');
    }
}
