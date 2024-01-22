<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use App\Services\User\UserService;
use App\Services\Category\CategoryService;

class DashboardController extends BaseController
{
    public function __construct(
        protected UserService $userService,
        protected CategoryService $categoryService
    )
    {
        $this->userService = $userService;
    }
    public function index(){
        $this->setPageTitle('Admin Dashboard');
        // $totalActiveDrivers = $this->userService->getTotalUsersByCondition('driver', ['is_approve' => 1, 'is_registered' => 1]);
        // $totalPendingDrivers = $this->userService->getTotalUsersByCondition('driver', ['is_approve' => 0, 'is_registered' => 1]);

        $activeDrivers = $this->userService->findUserByRole(['is_approve' => 1, 'is_registered' => 1], 'driver');
        $pendingDrivers = $this->userService->findUserByRole(['is_approve' => 0, 'is_registered' => 1], 'driver');

        $firstActiveUserVehicleType = '';
        $totalActiveDrivers = count($activeDrivers);
        if($totalActiveDrivers){
            $firstActiveUserVehicleType = $activeDrivers[0]->vehicle->vehicleType->slug;
        }

        $firstPendingUserVehicleType = '';
        $totalPendingDrivers = count($pendingDrivers);
        if($totalPendingDrivers){
            $firstPendingUserVehicleType = $pendingDrivers[0]->vehicle->vehicleType->slug;
        }
        $totalDeletedDrivers = $this->userService->getTotalDeletedUsersByCondition('driver', ['is_registered' => 1]);
        $unregisteredDrivers = $this->userService->findUserByRole(['is_registered' => 0], 'driver');
        $totalUnregisteredDrivers = count($unregisteredDrivers);

        $totalCustomer = $this->userService->getTotalUsers('customer');
        return view('admin.dashboard.index', compact('totalActiveDrivers', 'totalPendingDrivers', 'totalDeletedDrivers', 'totalUnregisteredDrivers', 'totalCustomer', 'firstActiveUserVehicleType', 'firstPendingUserVehicleType'));
    }
    public function profile(Request $request){
        $this->setPageTitle('Admin Profile');
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
        }
        return view('admin.dashboard.profile');
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
                    return $this->responseRedirectBack('Password Changed Successfully','success');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . 'on' . $e->getFile() . 'in' . $e->getLine());
                return $this->responseRedirectBack('Something went wrong','error');
            }
        }
        return view('admin.dashboard.change-password');
    }

}
