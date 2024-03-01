<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $roles = Role::select('*');

        $totalRecords = $this->count($roles);
        $roles = $roles->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'roles' => $roles,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($roles)
    {
        return $roles->count();
    }

    public function getById($id)
    {
        return Role::findOrFail($id);
    }

    public function getByIds($ids)
    {
        return Role::whereIn('id', $ids)->get();
    }
    
    public function create($request)
    {
        return Role::create([
            'name' => $request->name
        ]);
    }

    public function update($request, $key)
    {
        $role = $this->getByKey($key);
        
        $role->update([
            'name' => $request->name
        ]);

        return $role;
    }

    public function getByKey($key)
    {
        return Role::where('key', $key)->firstOrFail();
    }

    public function model()
    {
        return new Role();
    }
}
