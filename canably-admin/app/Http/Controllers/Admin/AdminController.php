<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\Order\OrderService;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends BaseController
{

    protected $roleService;

    protected $userService;
    protected $orderService;

    public function __construct(
        UserService $userService,
        RoleService $roleService,
        OrderService $orderService
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->orderService = $orderService;
    }
    public function index()
    {

        if (auth()->user()->can('view-dashboard')) {
            $this->setPageTitle('Admin Dashboard');
            $filterConditions = [
                'is_active' => 1,
            ];
            $filterSellerConditions = [
                'is_active' => 1,
            ];

            $customers = $this->userService->getCustomersDashboard('customer', $filterConditions, 10);
            $orders = $this->orderService->getOrders()->sortByDesc('id')->take(15);
            // dd($orders);
            $sellers = $this->userService->getSellersDashboard('seller', $filterSellerConditions, 5);


            return view('admin.dashboard.dashboard', compact('customers', 'sellers','orders'));
        } else {
            $this->setPageTitle('Admin Profile');
            return redirect()->route('admin.profile');
        }
    }

    public function profile(Request $request)
    {
        $this->setPageTitle('User Profile');
        if ($request->post()) {
            $request->validate([
                'mobile_number' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
            ]);
            DB::begintransaction();
            try {
                $isUserUpdated = $this->userService->userDetailsUpdate($request->except(['_token', 'email']), auth()->user()->id);
                if ($isUserUpdated) {
                    DB::commit();
                    return $this->responseRedirectBack('Profile updated successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            }

        }
        return view('admin.dashboard.profile');
    }

    public function adminUser(Request $request)
    {
        $this->setPageTitle('Admin Users');
        $users = $this->userService->getAdmins()->paginate(15);
        return view('admin.dashboard.admin-user', compact('users'));
    }

    public function adminUserEdit(Request $request, $uuid)
    {
        $userId = uuidtoid($uuid, 'users');
        $userDetails = $this->userService->findById($userId);
        if ($request->post()) {
            DB::beginTransaction();
            try {
                $isUserUpdated = $this->userService->updateUserDetails($request->except(['_token', 'email']), $userId);
                if ($isUserUpdated) {
                    DB::commit();
                    return $this->responseRedirect('admin.user.list', 'User updated successfully', 'success', false);
                }
            } catch (\Exception$e) {
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong', 'error', true);
            }

        }
        $this->setPageTitle('User Edit');
        return view('admin.dashboard.edit-user', compact('userDetails'));
    }
    public function attachPermission(Request $request, $uuid)
    {
        $this->setPageTitle('Admin Users');
        $id = uuidtoid($uuid, 'users');
        $user = $this->userService->findUser($id);
        $permissions = $this->roleService->getAllPermissions();
        $permissions = $permissions->chunk(ceil($permissions->count() / 13));
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
        return view('admin.dashboard.attach-permission', compact('user', 'permissions'));
    }

    public function changePassword(Request $request)
    {
        $this->setPageTitle('Change Password');
        $userId = auth()->user()->id;
        if ($request->post()) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|string|different:current_password',
                'confirm_password' => 'required|same:new_password',
            ]);
            $isPasswordValidated = $this->userService->validatePassword($request->current_password, $userId);
            if ($isPasswordValidated) {
                $isProcessed = $this->userService->saveUserProfileDetails([
                    'password' => $request->new_password,
                ], $userId);
                if ($isProcessed) {
                    //Notify user for password changed
                    $mailData = [];
                    $mailData['type'] = 'passwordChanged';
                    event(new SiteNotificationEvent(auth()->user(), $mailData));
                    return $this->responseRedirect('admin.change.password', 'Password has been updated successfully', 'success', false, false);
                } else {
                    return $this->responseRedirectBack('We are facing some technical issue now. Please try again after some time.', 'error', true, true);
                }
            } else {
                return $this->responseRedirectBack('Invalid current password provided, please try again!', 'error', true, true);
            }
        }
        return view('admin.dashboard.change-password');
    }
}
