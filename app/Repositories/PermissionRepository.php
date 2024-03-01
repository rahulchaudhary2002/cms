<?php

namespace App\Repositories;

use App\Interfaces\PermissionRepositoryInterface;
use App\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;
        
        $permissions = Permission::select('*');

        if ($request->name) {
            $permissions = $permissions->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->type) {
            $permissions = $permissions->where('type', 'LIKE', '%' . $request->type . '%');
        }

        $totalRecords = $this->count($permissions);
        $permissions = $permissions->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'permissions' => $permissions,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($data) {
        return Permission::count();
    }

    public function getById($id)
    {
        return Permission::findOrFail($id);
    }

    public function getByKey($key)
    {
        return Permission::where('key', $key)->firstOrFail();
    }

    public function getByIds($ids)
    {
        return Permission::whereIn('id', $ids)->get();
    }

    public function create($request)
    {
        return Permission::create([
            'name' => $request->name,
            'type' => $request->type,
            'primary' => 0,
            'url_id' => $request->url
        ]);
    }

    public function update($request, $key)
    {
        $permission = $this->getByKey($key);
        
        $permission->update([
            'name' => $request->name,
            'type' => $request->type,
            'primary' => $permission->primary,
            'url_id' => $permission->primary == 1 ? null : $request->url
        ]);

        return $permission;
    }

    public function model()
    {
        return new Permission();
    }
}
