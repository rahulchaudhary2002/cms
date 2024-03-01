<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->permissionService->getPermissions($request);
        
        return view('modules.permission.index', compact('result'));        
    }

    public function create()
    {
        $roles = $this->permissionService->getRoles();
        $urls = $this->permissionService->getUrls();

        return view('modules.permission.create', compact('roles', 'urls'));
    }

    public function store(CreatePermissionRequest $request)
    {
        if($this->permissionService->createPermission($request)) {
            return redirect()->route('permission.index')->with('success', 'Permission is created.');
        }
        return redirect()->route('permission.index')->with('error', 'Permission is not created.');
    }

    public function edit($key)
    {
        $permission = $this->permissionService->getPermissionByKey($key);
        $roles = $this->permissionService->getRoles();
        $urls = $this->permissionService->getUrls();

        if($permission->primary == 1) {
            abort(404);
        }

        return view('modules.permission.edit', compact('permission', 'roles', 'urls'));
    }

    public function update(UpdatePermissionRequest $request, $key)
    {
        if($this->permissionService->updatePermission($request, $key)) {
            return redirect()->route('permission.index')->with('success', 'Permission is updated.');
        }
        return redirect()->route('permission.index')->with('error', 'Permission is not updated.');
    }
}
