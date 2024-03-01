<?php

namespace App\Services;

use App\Interfaces\PermissionRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\URL;

class PermissionService
{
    private PermissionRepositoryInterface $permissionRepository;
    private RoleRepositoryInterface $roleRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository, RoleRepositoryInterface $roleRepository) {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
    }

    public function getPermissions($request)
    {
        return $this->permissionRepository->get($request);
    }

    public function getPermissionByKey($key)
    {
        return $this->permissionRepository->getByKey($key);
    }

    public function createPermission($request)
    {
        $permission = $this->permissionRepository->create($request);
        $request->roles ? $permission->syncRoles($this->roleRepository->getByIds($request->roles)) : '';
        
        return $permission;
    }

    public function updatePermission($request, $key)
    {
        $permission = $this->permissionRepository->update($request, $key);
        $permission->detach($permission->rolePermissions) ?? '';
        $request->roles ? $permission->syncRoles($this->roleRepository->getByIds($request->roles)) : '';
        
        return $permission;
    }

    public function getRoles()
    {
        return $this->roleRepository->model()->get();
    }

    public function getUrls() {
        return URL::get();
    }
}
