<?php

namespace App\Services;

use App\Interfaces\PermissionRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;

class RoleService
{
    private PermissionRepositoryInterface $permissionRepository;
    private RoleRepositoryInterface $roleRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository, RoleRepositoryInterface $roleRepository) {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
    }

    public function getRoles($request)
    {
        return $this->roleRepository->get($request);
    }

    public function getRoleByKey($key)
    {
        return $this->roleRepository->getByKey($key);
    }

    public function createRole($request)
    {
        $role = $this->roleRepository->create($request);
        
        if($request->permissions) {
            $role->syncPermissions($this->permissionRepository->getByIds($request->permissions));
        }
        
        return $role;
    }

    public function updateRole($request, $key)
    {
        $role = $this->roleRepository->update($request, $key);

        $role->detach($role->rolePermissions) ?? '';
        
        if($request->permissions) {
            $role->syncPermissions($this->permissionRepository->getByIds($request->permissions));
        }
        
        return $role;
    }

    public function getPermissions()
    {
        return $this->permissionRepository->model()->get();
    }
}
