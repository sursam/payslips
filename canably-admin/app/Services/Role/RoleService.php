<?php

namespace App\Services\Role;

use App\Contracts\Role\RoleContract;

class RoleService
{
    protected $roleRepository;

    /**
     * class InviteService constructor
     */
    public function __construct(RoleContract $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function findRoleById($id){
        return $this->roleRepository->findById($id);
    }

    public function getList($start, $limit, $order, $dir, $search=null)
    {
        return $this->roleRepository->getList($start, $limit, $order, $dir, $search);
    }

    public function getTotalData($search=null)
    {
        return $this->roleRepository->getTotalData($search);
    }

    public function getPermissionList($start, $limit, $order, $dir, $search=null)
    {
        return $this->roleRepository->getPermissionList($start, $limit, $order, $dir, $search);
    }

    public function getTotalPermissionData($search=null)
    {
        return $this->roleRepository->getTotalPermissionData($search);
    }

    public function getAllPermissions(){
        return $this->roleRepository->getAllPermissions();
    }

    public function addRole(array $attributes)
    {
        return $this->roleRepository->createRole($attributes);
    }

    public function addPermission(array $attributes)
    {
        return $this->roleRepository->createPermission($attributes);
    }

}
