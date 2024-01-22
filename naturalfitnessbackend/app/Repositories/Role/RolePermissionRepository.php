<?php
namespace App\Repositories\Role;

use App\Contracts\Role\RolePermissionContract;
use App\Models\User\Permission;
use App\Models\User\Role;
use App\Repositories\BaseRepository;


class RolePermissionRepository extends BaseRepository implements RolePermissionContract
{

    public function __construct(Role $model,protected Permission $permissionModel)
    {
        parent::__construct($model);
        $this->permissionModel= $permissionModel;
    }

    public function getTotalData($search = null)
    {
        if($search) {
            return $this->model->where('name','LIKE',"%{$search}%")
                ->orWhere('slug', 'LIKE',"%{$search}%")
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

    public function getAllRoles($filterConditions,string $orderBy = 'id', $sortBy = 'asc'){
        return $this->model->where($filterConditions)->orderBy($orderBy, $sortBy)->get();

    }
}
