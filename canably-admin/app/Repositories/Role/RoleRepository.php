<?php
namespace App\Repositories\Role;

use App\Contracts\Role\RoleContract;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\BaseRepository;


class RoleRepository extends BaseRepository implements RoleContract
{

    public function __construct(Role $model,Permission $permissionModel)
    {
        parent::__construct($model);
        $this->permissionModel= $permissionModel;
    }

    public function getTotalData($search = null)
    {
        if($search) {
            return $this->model->where('name','LIKE',"%{$search}%")
                ->orWhere('slug', 'LIKE',"%{$search}%")
                ->orWhere('short_code', 'LIKE',"%{$search}%")
                ->orWhere('role_type', 'LIKE',"%{$search}%")
                ->count();
        }

        return $this->model->count();
    }

    public function getTotalPermissionData($search = null)
    {
        if($search) {
            return $this->permissionModel->where('name','LIKE',"%{$search}%")
                ->orWhere('slug', 'LIKE',"%{$search}%")
                ->count();
        }

        return $this->permissionModel->count();
    }

    /**
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getList($start, $limit, $order, $dir, $search = null)
    {
        if($search) {
            return $this->model->where('name','LIKE',"%{$search}%")
                ->orWhere('slug', 'LIKE',"%{$search}%")
                ->orWhere('short_code', 'LIKE',"%{$search}%")
                ->orWhere('role_type', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        return $this->model->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }
    /**
     * @param $start
     * @param $limit
     * @param $order
     * @param $dir
     * @param null $search
     * @return mixed
     */
    public function getPermissionList($start, $limit, $order, $dir, $search = null)
    {
        if($search) {
            return $this->permissionModel->where('name','LIKE',"%{$search}%")
                ->orWhere('slug', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        return $this->permissionModel->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    }

    public function findById($id){
        return $this->find($id);
    }

    public function getAllPermissions(){
        return $this->permissionModel->NotDashboard()->get();
    }

    public function createRole($attributes){
        return $this->model->create($attributes);
    }
    public function createPermission($attributes){
        return $this->permissionModel->create($attributes);
    }
}
