<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->roleService->getRoles($request);
        
        return view('modules.role.index', compact('result'));        
    }

    public function create()
    {
        $permissionsGroups = $this->roleService->getPermissions()->groupBy('type');
        
        return view('modules.role.create', compact('permissionsGroups'));
    }

    public function store(CreateRoleRequest $request)
    {
        if($this->roleService->createRole($request)) {
            return redirect()->route('role.index')->with('success', 'Role is created.');
        }

        return redirect()->route('role.index')->with('error', 'Role is not created.');
    }

    public function edit($key)
    {
        $role = $this->roleService->getRoleByKey($key);
        $permissions = $this->roleService->getPermissions();
        $permissionsGroups = $permissions->groupBy('type');
        
        if($role->key == 'superadmin') {
            abort(404);
        }

        return view('modules.role.edit', compact('role', 'permissions', 'permissionsGroups'));
    }

    public function update(UpdateRoleRequest $request, $key)
    {
        if($this->roleService->updateRole($request, $key)) {
            return redirect()->route('role.index')->with('success', 'Role is updated.');
        }
        
        return redirect()->route('role.index')->with('error', 'Role is not updated.');
    }
}
