<?php

namespace App\Services;

use App\Interfaces\PermissionRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\TeacherRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private TeacherRepositoryInterface $teacherRepository;
    private RoleRepositoryInterface $roleRepository;
    private PermissionRepositoryInterface $permissionRepository;

    public function __construct(UserRepositoryInterface $userRepository, TeacherRepositoryInterface $teacherRepository, RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->teacherRepository = $teacherRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function getUsers($request)
    {
        return $this->userRepository->get($request);
    }

    public function getUserByKey($key)
    {
        return $this->userRepository->getByKey($key);
    }

    public function createUser($request)
    {
        try {
            $user = null;

            DB::transaction(function () use ($request, &$user) {
                $user = $this->userRepository->create($request);
                $user = $this->assignRolePermission($request, $user);
                
                if($user->hasRole('teacher')) {
                    $this->teacherRepository->create($request, $user->id);
                }
            });

            return $user;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateUser($request, $key)
    {
        try {
            $user = null;

            DB::transaction(function () use ($request, $key, &$user) {
                $user = $this->userRepository->update($request, $key);
                $user->detach($user->permissions, $user->roles) ?? '';
                $user = $this->assignRolePermission($request, $user);

                if($user->hasRole('teacher')) {
                    $this->teacherRepository->update($request, $user->id);
                }
            });

            return $user;
        } catch (Exception $e) {
            return false;
        }
    }

    public function assignRolePermission($request, $user)
    {
        foreach ($request->roles as $role) {
            $user->assignRole($this->roleRepository->getById($role)->key);
        }

        if ($request->permissions) {
            $permissionIds = $request->permissions;
            $permissions = $this->permissionRepository->getByIds($permissionIds);
            $user->givePermissionTo($permissions);
        }

        return $user;
    }

    public function mergePermissionsRanderHTML($request)
    {
        $permissionsViaRole = $this->getPermissionsViaRole($request)->pluck('id')->toArray();
        $permissions = $this->permissionRepository->model()->get();
        $permissionsGroups = $permissions->groupBy('type');

        return view('includes.bulk-permission-checkbox', compact('permissionsViaRole', 'permissions', 'permissionsGroups'))->render();
    }

    public function getPermissionsViaRole($request)
    {
        $permissions = [];
        
        foreach ($request->ids ?? [] as $id) {
            $role = $this->roleRepository->getById($id);
            $permissions = array_merge($permissions, $role->permissions->toArray());
        }

        return collect($permissions)->unique('id');
    }

    public function getRoles()
    {
        return $this->roleRepository->model()->where('key', '!=', 'student')->get();
    }

    public function getPermissions()
    {
        return $this->permissionRepository->model()->get();
    }
}
