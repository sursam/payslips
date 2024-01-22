<?php

namespace App\Services\Role;

use App\Contracts\Role\RolePermissionContract;

class RolePermissionService
{

    /**
     * class InviteService constructor
     */
    public function __construct(protected RolePermissionContract $rolePermissionRepository)
    {
        $this->rolePermissionRepository = $rolePermissionRepository;
    }

    public function findRoleById($id){
        return $this->rolePermissionRepository->findById($id);
    }

    public function getList($start, $limit, $order, $dir, $search=null)
    {
        return $this->rolePermissionRepository->getList($start, $limit, $order, $dir, $search);
    }
    public function getAllRoles($filterConditions,string $orderBy = 'id', $sortBy = 'asc')
    {
        return $this->rolePermissionRepository->getAllRoles($filterConditions,$orderBy,$sortBy);
    }

    public function getTotalData($search=null)
    {
        return $this->rolePermissionRepository->getTotalData($search);
    }

    public function getPermissionList($start, $limit, $order, $dir, $search=null)
    {
        return $this->rolePermissionRepository->getPermissionList($start, $limit, $order, $dir, $search);
    }

    public function getTotalPermissionData($search=null)
    {
        return $this->rolePermissionRepository->getTotalPermissionData($search);
    }

    public function getAllPermissions(){
        return $this->rolePermissionRepository->getAllPermissions();
    }

    public function addRole(array $attributes)
    {
        return $this->rolePermissionRepository->create($attributes);
    }

    public function addPermission(array $attributes)
    {
        return $this->rolePermissionRepository->createPermission($attributes);
    }

}
