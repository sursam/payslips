<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Services\Role\RolePermissionService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;

class RolePermissionController extends BaseController
{
    public function __construct(protected RolePermissionService $rolePermissionService)
    {
        $this->rolePermissionService= $rolePermissionService;
    }

    public function roles(Request $request){
        $this->setPageTitle('All Roles');
        return view('admin.settings.role.index');
    }

    public function permissions(Request $request){
        $this->setPageTitle('All Permissions');
        return view('admin.settings.permission.index');
    }

    public function addRole(Request $request){
        $this->setPageTitle('Add Role');
        if($request->post()){
            $request->validate([
                'name'=> 'required|unique:roles,name'
            ]);
            DB::beginTransaction();
            try{
                $isRoleCreated= $this->rolePermissionService->addRole($request->only(['name']));
                if($isRoleCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.settings.role.list',"Role Added Successfully",'success');
                }
            }catch(\Exception $e){
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong','error',true);
            }
        }
        return view('admin.settings.role.add');
    }

    public function addPermission(Request $request){
        $this->setPageTitle('Add Permission');
        if($request->post()){
            $request->validate([
                'name'=> 'required|unique:permissions,name'
            ]);
            DB::beginTransaction();
            try{
                $isPermissionCreated= $this->rolePermissionService->addPermission($request->only(['name']));
                if($isPermissionCreated){
                    DB::commit();
                    return $this->responseRedirect('admin.permission.list',"Permission Added Successfully",'success');
                }
            }catch(\Exception $e){
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong','error',true);
            }
        }
        return view('admin.settings.permission.add');
    }

    public function attachPermissions(Request $request,$id){
        $this->setPageTitle('Attach Permissions');
        $roleData= $this->rolePermissionService->findRoleById($id);
        $permissions= $this->rolePermissionService->getAllPermissions();
        $count= count($permissions);
        $chunk= $count/4;
        $permissions= $permissions->chunk(ceil($permissions->count()/$chunk));
        if($request->post()){
            // dd($request->permission);
            DB::begintransaction();
            try{
                $roleData->permissions()->detach();
                $isPermissionAttached= $roleData->givePermissionsTo( (array) $request->permission);
                if($isPermissionAttached){
                    DB::commit();
                    return $this->responseRedirect('admin.settings.role.list','Permission attached successfully','success');
                }
            }catch(\Exception $e){
                DB::rollBack();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something Went Wrong','error',true);
            }
        }
        return view('admin.settings.role.attach-permission',compact('permissions','roleData'));

    }

}
