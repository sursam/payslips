<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\CustomExport;
use App\Exports\CustomDeletedExport;
use App\Models\Company\Service;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\SiteNotification;
use App\Services\Location\StateService;
use App\Http\Controllers\BaseController;
use App\Services\Company\CompanyService;
use App\Services\Product\ProductService;
use App\Services\Vehicle\VehicleService;
use App\Services\Category\CategoryService;
use App\Notifications\SendPushNotification;
use App\Services\Role\RolePermissionService;

class UserController extends BaseController
{
    public function __construct(
        protected UserService $userService,
        protected RolePermissionService $rolePermissionService,
        protected CompanyService $companyService,
        protected StateService $stateService,
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected VehicleService $vehicleService
    )
    {
        $this->userService = $userService;
        $this->rolePermissionService= $rolePermissionService;
        $this->companyService= $companyService;
        $this->stateService= $stateService;
        $this->productService= $productService;
        $this->categoryService= $categoryService;
        $this->vehicleService= $vehicleService;
    }

    public function index(Request $request, $userType = 'admin')
    {
        $pageTitle = $userType == 'admin' ? 'Admin Users' : ucfirst($userType).'s';
        $this->setPageTitle($pageTitle);
        return view('admin.users.index', compact('userType', 'pageTitle'));
    }

    public function add(Request $request, $role = 'admin')
    {
        $this->setPageTitle('Add '.ucfirst($role));
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                // 'email' => 'required|email|unique:users,email',
                'mobile_number' => 'required|numeric|min:1000000000|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                'role' => 'required|string|in:'.$role,
            ]);
            $request->merge(['password' => bcrypt($request->mobile_number), 'is_registered' => 1]);
            DB::beginTransaction();
            try {
                $isUserCreated = $this->userService->createUser($request->except('_token'));
                if ($isUserCreated) {
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.users.list', [$role], ucfirst($role).' created successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.users.add', compact('role'));

    }
    public function edit(Request $request, $role = 'admin', $uuid)
    {
        $pageTitle = $role == 'admin' ? 'Admin User' : ucfirst($role);
        $this->setPageTitle($pageTitle);
        $id = uuidtoid($uuid, 'users');
        $userData= $this->userService->findUserById($id);
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                'mobile_number' => 'required|numeric|min:1000000000|unique:users,mobile_number,'.$id.',id,deleted_at,NULL',
            ]);
            DB::beginTransaction();
            try {
                $isUserEdited = $this->userService->updateUser($request->except(['_token', 'email']), $id);
                if ($isUserEdited) {
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.users.list', [$role], ucfirst($role).' updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.users.edit',compact('userData', 'role', 'pageTitle'));
    }


    public function customerList(Request $request)
    {
        $this->setPageTitle('Cusrtomers');
        return view('admin.customers.index');
    }

    public function addCustomer(Request $request)
    {
        $this->setPageTitle('Add Customer');
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                'email' => 'required|email|unique:users,email',
                'mobile_number' => 'required|numeric|min:1000000000|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                'role' => 'required|string|in:customer',
            ]);
            $request->merge(['password' => bcrypt($request->mobile_number)]);
            DB::beginTransaction();
            try {
                $isUserCreated = $this->userService->createUser($request->except('_token'));
                if ($isUserCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.customer.list', 'Customer Created Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.customers.add');

    }
    public function editCustomer(Request $request, $uuid)
    {
        $this->setPageTitle('Edit User');
        $id = uuidtoid($uuid, 'users');
        $userData= $this->userService->findUserById($id);
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                'mobile_number' => 'required|numeric|min:1000000000|unique:users,mobile_number,'.$id.',id,deleted_at,NULL',
            ]);
            DB::beginTransaction();
            try {
                $isUserEdited = $this->userService->updateUser($request->except(['_token', 'email']), $id);
                if ($isUserEdited) {
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.users.customer.company', [$userData->uuid], 'Customer Updated Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.customers.edit',compact('userData'));
    }

    public function company(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Company');
        $userId = uuidtoid($uuid, 'users');
        $userData= $this->userService->findUserById($userId);
        $companyData= $userData->company ?? $userData->company()->create(['is_active' => false]);
        $states= $this->stateService->findStates(['country_id'=>207]);
        // dd($states->first()->cities);
        if ($request->post()) {
            // dd($request->all());
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
            DB::beginTransaction();
            try {
                $request->merge(['country_id'=>207]);
                $isCompanyEdited = $this->companyService->createOrUpdateCompany($request->except(['_token']),$companyData->id);
                if ($isCompanyEdited) {
                    if($request->services){
                        Service::where('company_id', $companyData->id)->forceDelete();
                        foreach($request->services as $service){
                            $serviceData = $this->productService->createOrUpdateService(['company_id'=> $companyData->id, 'name'=>$service]);
                        }
                    }
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.users.customer.company', [$userData->uuid], 'Company Information Updated Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.customers.company',compact('companyData', 'userData', 'states'));
    }

    public function attachPermissions(Request $request, $role = 'admin', $uuid)

    {

        $this->setPageTitle('Admin Users');

        $id = uuidtoid($uuid, 'users');

        $user = $this->userService->findUser($id);

        $permissions = $this->rolePermissionService->getAllPermissions();

        $count= count($permissions);
        $chunk= $count/4;
        $permissions= $permissions->chunk(ceil($permissions->count()/$chunk));

        //dd($permissions);

        if ($request->post()) {

            DB::begintransaction();

            try {

                $user->permissions()->detach();

                $isPermissionAttached = $user->givePermissionsTo($request->permission);

                if ($isPermissionAttached) {

                    DB::commit();

                    return $this->responseRedirect('admin.user.list', 'Permission attached to user successfully', 'success');

                }

            } catch (\Exception$e) {

                DB::rollBack();

                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());

                return $this->responseRedirectBack('Something Went Wrong', 'error', true);

            }

        }

        return view('admin.users.attach-permission', compact('user', 'permissions'));

    }
    public function viewCustomer(Request $request, $uuid)
    {
        $this->setPageTitle('View User');
        $id = uuidtoid($uuid, 'users');
        $userData= $this->userService->findUserById($id);
        return view('admin.customers.view',compact('userData'));
    }

    public function councilList(Request $request)
    {
        $this->setPageTitle('Users');
        return view('admin.councils.index');
    }

    public function addCouncil(Request $request)
    {
        $this->setPageTitle('Add User');
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|string|in:council',
            ]);
            DB::beginTransaction();
            try {
                $isUserCreated = $this->userService->createCouncil($request->except('_token'));
                if ($isUserCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.users.council.list', 'Council Created Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.councils.add');

    }
    public function editCouncil(Request $request, $uuid)
    {
        $this->setPageTitle('Edit User');
        $id = uuidtoid($uuid, 'users');
        $userData= $this->userService->findUserById($id);
        //dd($userData->profile_picture);
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
            ]);
            DB::beginTransaction();
            try {
                $isUserEdited = $this->userService->updateCouncil($request->except(['_token', 'email']), $id);
                if ($isUserEdited) {
                    DB::commit();
                    return $this->responseRedirect('admin.users.council.list', 'Council Updated Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.councils.edit',compact('userData'));
    }
    public function agentList(Request $request)
    {
        $this->setPageTitle('Users');
        return view('admin.agents.index');
    }

    public function addAgent(Request $request)
    {
        $this->setPageTitle('Add User');
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|string|in:agent',
            ]);
            DB::beginTransaction();
            try {
                $isUserCreated = $this->userService->createAgent($request->except('_token'));
                if ($isUserCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.users.agent.list', 'Agent Created Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.agents.add');

    }
    public function editAgent(Request $request, $uuid)
    {
        $this->setPageTitle('Edit User');
        $id = uuidtoid($uuid, 'users');
        $userData= $this->userService->findUserById($id);
        //dd($userData->profile_picture);
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
            ]);
            DB::beginTransaction();
            try {
                $isUserEdited = $this->userService->updateAgent($request->except(['_token', 'email']), $id);
                if ($isUserEdited) {
                    DB::commit();
                    return $this->responseRedirect('admin.users.agent.list', 'Agent Updated Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.agents.edit',compact('userData'));
    }

    public function driverList(Request $request, $type = '')
    {
        $this->setPageTitle('Drivers');
        $status = $request->status ? $request->status : '';
        return view('admin.drivers.index', compact('type', 'status'));
    }
    public function viewDriver(Request $request, $uuid)
    {
        $this->setPageTitle('View Driver');
        $id = uuidtoid($uuid, 'users');
        $userData= $this->userService->findUserById($id);
        // dd($userData->mediaStatus('aadhar_front'));
        return view('admin.drivers.view',compact('userData'));
    }
    public function viewDeletedDriver(Request $request, $uuid)
    {
        $this->setPageTitle('View Driver');
        $id = uuidtoid($uuid, 'users');
        $userData= $this->userService->findDeletedUserById($id);
        //dd($id);
        return view('admin.drivers.view-deleted',compact('userData'));
    }
    public function addDriver(Request $request)
    {
        $this->setPageTitle('Add Driver');
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                'email' => 'nullable|email|unique:users,email,NULL,id,deleted_at',
                'aadhar_front' => 'required',
                'aadhar_back' => 'required',
                'licence_front' => 'required',
                'licence_back' => 'required',
                'mobile_number' => 'required|numeric|min:1000000000|unique:users,mobile_number,NULL,id,deleted_at,NULL',
                'role' => 'required|string|in:driver',
            ]);
            $request->merge(['password' => bcrypt($request->mobile_number), 'is_aadhar_approve' => 1, 'is_licence_approve' => 1]);
            DB::beginTransaction();
            try {
                // $request->merge(['is_approve' => 0]);
                $isUserCreated = $this->userService->createUser($request->except('_token'));
                if ($isUserCreated) {
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.driver.vehicle', [$isUserCreated->uuid], 'Driver Created Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.drivers.add');

    }
    public function editDriver(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Driver');
        $id = uuidtoid($uuid, 'users');
        $userData= $this->userService->findUserById($id);
        $currentTab = 'edit';
        if ($request->post()) {
            $request->validate([
                'first_name' => 'required|string|min:1',
                'last_name' => 'required|string|min:1',
                'email' => 'nullable|email|unique:users,email,'.$id.',id,deleted_at,NULL',
                // 'aadhar_front' => 'required',
                // 'aadhar_back' => 'required',
                // 'licence_front' => 'required',
                // 'licence_back' => 'required',
                // 'mobile_number' => 'required|numeric|min:1000000000|unique:users,mobile_number,'.$id.',id,deleted_at,NULL',
            ]);
            DB::beginTransaction();
            try {
                $request->merge(['is_aadhar_approve' => 0, 'is_licence_approve' => 0]);
                $isUserEdited = $this->userService->updateUser($request->except(['_token', 'mobile_number']), $id);
                if ($isUserEdited) {
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.driver.list', [$userData->vehicle?->vehicleType->slug], 'Driver Updated Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.drivers.edit',compact('userData', 'currentTab'));
    }

    public function vehicle(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Vehicle');
        $userId = uuidtoid($uuid, 'users');
        // dd($userId);
        $userData = $this->userService->findUserById($userId);
        $vehicleData = $userData->vehicle ?? $userData->vehicle()->create(['is_active' => false]);
        $filterConditions = [];
        $filterConditionsCategory = ['parent_id' => null, 'type' => 'vehicle'];
        $vehicleTypes = $this->categoryService->listCategories($filterConditionsCategory);
        $vehicleCompanies = $this->companyService->listCompanies($filterConditions);
        $currentTab = 'vehicle';
        //dd($vehicleCompanies);
        if ($request->post()) {
            $validateArr = [
                'registration_number'=> 'required|string|reg_unique:vehicles,registration_number,'.$vehicleData->id.',id,deleted_at,NULL',
                'category_id'=> 'required|string|exists:categories,uuid',
                // 'company_id'=> 'required|string|exists:companies,uuid',
                // 'user_id'=> 'required|string|exists:users,uuid'
            ];
            $request->merge(['user_id' => $uuid]);
            $dif_img = explode("/", $vehicleData->vehicleDocument('rc_front'));
            if(end($dif_img) == 'no-image.png'){
                $validateArr['rc_front'] = 'required';
                $validateArr['rc_back'] = 'required';
                $validateArr['vehicle_image'] = 'required';
            }
            $request->validate($validateArr, [
                'reg_unique' => 'Vehicle number already exists!',
            ]);
            DB::beginTransaction();
            try {
                $isVehicleEdited = $this->vehicleService->createOrUpdateVehicle($request->except(['_token']),$vehicleData->id);
                if ($isVehicleEdited) {
                    DB::commit();
                    // dd($userData->vehicle->vehicleType->slug);
                    if($userData->vehicle->vehicleType){
                        $vehicleTypeSlug = $userData->vehicle->vehicleType->slug;
                    }else{
                        $typeId = uuidtoid($request->category_id, 'categories');
                        $vehicleType = $this->categoryService->findCategoryById($typeId);
                        $vehicleTypeSlug = $vehicleType->slug;
                    }
                    return $this->responseRedirectWithQueryString('admin.driver.list', [$vehicleTypeSlug], 'Vehicle Information Updated Successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.drivers.vehicle',compact('vehicleData', 'vehicleTypes', 'vehicleCompanies', 'userData', 'currentTab'));
    }
    public function wallet(Request $request, $uuid)
    {
        $this->setPageTitle('Wallet');
        $userId = uuidtoid($uuid, 'users');
        $userData = $this->userService->findUserById($userId);
        $walletData = $userData->wallet ?? $userData->wallet()->create(['balance' => 0]);
        $currentTab = 'wallet';
        $rechargeAmounts = getSiteSetting('recharge_amount') ? explode(',', getSiteSetting('recharge_amount')) : [];
        if ($request->post()) {
            // dd($request->all());
            $request->validate([
                'rechargeAmount'=> 'required|numeric'
            ],
            [
                'rechargeAmount.required' => 'Recharge amount is required.'
            ]);
            DB::beginTransaction();
            try {
                $siteCommissionPercentage = getSiteSetting('site_commission_percentage');
                $rechargeAmount = $siteCommissionPercentage * $request->rechargeAmount;
                $isWalletUpdated = $userData->wallet()->increment('balance',$rechargeAmount);
                if ($isWalletUpdated) {
                    $isTransactionCreated = $userData->wallet->transactions()->create([
                        'user_id'               => auth()->user()->id,
                        'amount'                => $request->rechargeAmount,
                        'status'                => 1,
                        'type'                  => 'credit',
                        'currency'              => '₹'
                    ]);
                    if ($isTransactionCreated) {
                        $notiTitle = 'New Recharge Wallet';
                        $notiMessage = 'Your Wallet has been recharged by ₹'.$rechargeAmount;
                        $data = [
                            'type'=>'newRechargeWallet',
                            //'sender_id'=> auth()->user()->id,
                            'title'=>$notiTitle,
                            'message'=>$notiMessage
                        ];
                        $userData->notify(new SiteNotification($userData, $data));
                        if($userData->fcm_token){
                            $userData->notify(new SendPushNotification($notiTitle,$notiMessage,[$userData->fcm_token]));
                        }

                        DB::commit();
                        return $this->responseRedirectBack('Wallet updated successfully', 'success', false);
                    }
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }
        }
        return view('admin.drivers.wallet',compact('walletData', 'userData', 'currentTab', 'rechargeAmounts'));
    }
    public function unregisteredDriverList(Request $request, $type = '')
    {
        $this->setPageTitle('Unregistered Drivers');
        $status = $request->status ? $request->status : '';
        return view('admin.drivers.unregistered-list', compact('type', 'status'));
    }

    public function export($role, $vehicleType, $isRegistered = 1, $orderBy = 'id', $sortBy = 'DESC')
    {
        return Excel::download(new CustomExport($role, $vehicleType, $isRegistered, $orderBy, $sortBy), $role.',list-export-'.time().'.xlsx');
    }
    public function exportDeleted($role, $orderBy = 'id', $sortBy = 'DESC')
    {
        return Excel::download(new CustomDeletedExport($role, $orderBy, $sortBy), $role.'-deleted-list-export-'.time().'.xlsx');
    }
    public function deletedDriverList(Request $request, $type = '')
    {
        $this->setPageTitle('Deleted Drivers');
        $status = $request->status ? $request->status : '';
        return view('admin.drivers.deleted-list', compact('type', 'status'));
    }

    public function referrals(Request $request)
    {
        $this->setPageTitle('List Referrals');
        return view('admin.users.referral.list');
    }

    public function addReferral(Request $request)
    {
        $this->setPageTitle('Add Referral');
        $users = $this->userService->getAllUsers([], 'patient');
        $referenceSources = $this->categoryService->listCategories(['type' => 'referral']);
        if ($request->post()) {
            $request->validate([
                'category_id' => 'required',
                'user_id' => 'required',
                'name' => 'required_if:type,other',
                'mobile_number' => 'required_if:category_id,2,type,other',
                'ibd_number' => 'required_if:category_id,2'
            ]);
            DB::beginTransaction();
            try {
                if($request->type == 'self'){
                    $userData = $this->userService->findUserById($request->user_id);
                    $request->merge(['name' => $userData->full_name, 'mobile_number' => $userData->mobile_number]);
                }
                $isReferralCreated = $this->userService->createOrUpdateReferral($request->except('_token'));
                if ($isReferralCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.referral.user.list', 'Referral created successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.users.referral.add', compact('users', 'referenceSources'));

    }
    public function editReferral(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Referral');
        $id = uuidtoid($uuid, 'referrals');
        $referralData = $this->userService->findReferralById($id);
        $users = $this->userService->getAllUsers([], 'patient');
        $referenceSources = $this->categoryService->listCategories(['type' => 'referral']);
        if ($request->post()) {
            $request->validate([
                'category_id' => 'required',
                'user_id' => 'required',
                'name' => 'required_if:type,other',
                'mobile_number' => 'required_if:category_id,2,type,other',
                'ibd_number' => 'required_if:category_id,2'
            ]);
            DB::beginTransaction();
            try {
                if($request->type == 'self'){
                    $userData = $this->userService->findUserById($request->user_id);
                    $request->merge(['name' => $userData->full_name, 'mobile_number' => $userData->mobile_number]);
                }
                $isReferralUpdated = $this->userService->createOrUpdateReferral($request->except('_token'), $id);
                if ($isReferralUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.referral.user.list', 'Referral updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong.', 'error', true, true);
            }

        }
        return view('admin.users.referral.edit',compact('users', 'referenceSources', 'referralData'));
    }
}
