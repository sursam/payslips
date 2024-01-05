<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\AgentNotification;
use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\AddCustomerRequest;

class DeliveryAgentController extends BaseController
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
        $this->setPageTitle('All Agents');
        $users = $this->userService->getEmployees('delivery-agent','employee')->sortByDesc('id')->paginate(15);
        return view('admin.delivery-agent.index',compact('users'));
    }

    public function view(Request $request, $uuid){
        $this->setPageTitle('View Agent');
        $id = uuidtoid($uuid, 'users');
        $user= $this->userService->findUser($id);
        return view('admin.delivery-agent.view',compact('user'));
    }
    public function payouts(Request $request, $uuid){
        $this->setPageTitle('View Payouts');
        $id = uuidtoid($uuid, 'users');
        $user= $this->userService->findUser($id);
        if($request->post()){
            $request->validate([
                'amount'=>'required|numeric|min:1',
                'transactioned_at'=>'required|date'
            ]);
            DB::beginTransaction();
            try {
                $request->merge(['customer_id'=>1,'is_approve'=>true]);
                $isEarningCreated= $user->earnings()->create($request->except('_token'));
                if($isEarningCreated){
                    DB::commit();
                    /* $this->data['type'] == 'deliveryAssigned' ||
            $this->data['type'] == 'payoutGiven' */
                    $data= [
                        'type'=>'payoutGiven',
                        'amount'=> $request->amount
                    ];
                    $user->notify(new AgentNotification($data));
                    return $this->responseRedirectWithQueryString('admin.delivery.agent.payouts',['uuid'=>$uuid],'Payout created successfully','success');
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }
        $payouts= $this->userService->findUser($id)->earnings->sortByDesc('id')->paginate(15);
        return view('admin.delivery-agent.payouts',compact('payouts'));
    }


    public function addAgents(Request $request){
        $this->setPageTitle('Add Agent');
        return view('admin.delivery-agent.add');
    }

    public function store(Request $request){
        if ($request->post()) {
            $this->validate($request, [
                'first_name'        =>  'required|string',
                'last_name'         =>  'required|string',
                'email'             =>  'required|email|unique:users',
                'mobile_number'     =>  'required|numeric',
                'password'          =>  'required|string',
                'confirm_password'  =>  'required|string|same:password',
                'address'           =>  'sometimes|string|min:3|nullable',
                'zipcode'           =>  'sometimes|numeric|nullable',
                'agent_image'       =>  'sometimes|file|mimes:jpg,png,jpeg',
                'bank_details'      =>  'required|array',
                'bank_details.*'    =>  'required|string',
                'bank_details.account'  =>  'confirmed',

                ]);
            DB::beginTransaction();
            try{
                $request->merge(['registration_ip'=>$request->ip()]);
                $isAgentCreated= $this->userService->createOrUpdateAgent($request->except('_token'));
                if($isAgentCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.delivery.agent.list', 'Delivery Agent created Successfully' ,'success',false, false);
                }
            }catch(\Exception $e){
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong','error',true);
            }
        }

    }


    public function editAgents(Request $request, $uuid)
    {
        $this->setPageTitle('Edit Agent');
        $id = uuidtoid($uuid, 'users');
        $user= $this->userService->findUser($id);
        if ($request->post()) {
            $this->validate($request, [
                'first_name'        =>  'required|string',
                'last_name'         =>  'required|string',
                'mobile_number'     =>  'required|numeric',
                'address'           =>  'sometimes|string|min:3|nullable',
                'zipcode'           =>  'sometimes|numeric|nullable',
                'agent_image'       =>  'sometimes|file|mimes:jpg,png,jpeg',
                ]);
            DB::beginTransaction();
            try {
                $isAgentUpdated = $this->userService->createOrUpdateAgent($request->except(['_token','email']), $id);
                if ($isAgentUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.delivery.agent.list', 'Agent updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.delivery-agent.edit', compact('user'));
    }
}
