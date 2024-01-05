<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\AddCustomerRequest;

class CustomerController extends BaseController
{

    protected $roleService;

    protected $userService;

    public function __construct(
        UserService $userService,
        RoleService $roleService
    )
    {
        $this->userService    = $userService;
        $this->roleService    = $roleService;
    }
    public function index(Request $request){
        $this->setPageTitle('All Customers');
        $users = $this->userService->getCustomers('customer')->sortByDesc('id')->paginate(15);
        return view('admin.customer.index',compact('users'));
    }


    public function addCustomers(Request $request){
        $this->setPageTitle('Add Customer');
        return view('admin.customer.customer-add');
    }


    public function store(AddCustomerRequest $request){
        DB::beginTransaction();
        try{
            $request->merge(['registration_ip'=>$request->ip()]);
            $isCustomerCreated= $this->userService->createOrUpdateCustomer($request->except('_token'));
            if($isCustomerCreated){
                DB::commit();
                return $this->responseRedirect('admin.customer.list', 'Customer created Successfully' ,'success',false, false);
            }
        }catch(\Exception $e){
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong','error',true);
        }
    }


    public function editCustomers(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Customer');
        $id = uuidtoid($uuid, 'users');
        $user= $this->userService->findUser($id);
        if ($request->post()) {
            $this->validate($request, [
                'first_name'     =>  'required|string',
                'last_name'      =>  'required|string',
                'mobile_number'  =>  'required|numeric|unique:users,mobile_number,'.$id,
                'address'        =>  'sometimes|string|min:3|nullable',
                'country'        =>  'sometimes|string|nullable',
                'state'          =>  'sometimes|string|nullable',
                'city'           =>  'sometimes|string|nullable',
                'zipcode'        =>  'sometimes|numeric|nullable',
                'customer_image'  => 'sometimes|file|mimes:jpg,png,jpeg',
                ]);
            DB::beginTransaction();
            try {
                $isCustomerUpdated = $this->userService->createOrUpdateCustomer($request->except(['_token','email']), $id);
                if ($isCustomerUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.customer.list', 'Customer updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.customer.customer-edit', compact('user'));
    }

    public function viewAddress(Request $request,$uuid){
        $id= uuidtoid($uuid,'users');
        $this->setPageTitle('Customer Address');
        $addreses= $this->userService->findById($id)?->addressBook->paginate(15);
        return view('admin.customer.view-address-list',compact('addreses'));
    }

    public function editAddress(Request $request,$uuid){
        $this->setPageTitle('Edit Address');
        $id = uuidtoid($uuid,'addresses');
        $address= $this->userService->findAddress($id);
        if($request->post()){
            DB::beginTransaction();
            try {
                $isAddressUpdated = $this->userService->createOrUpdateAddress($request->except('_token'),$id);
                if ($isAddressUpdated) {
                    DB::commit();
                    return $this->responseRedirectWithQueryString('admin.customer.view.address',$isAddressUpdated->user->uuid, 'Address updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }

        }
        return view('admin.customer.edit-address',compact('address'));
    }
}
