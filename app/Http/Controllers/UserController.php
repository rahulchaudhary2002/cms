<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $result = (object) $this->userService->getUsers($request);
        $roles = $this->userService->getRoles();

        return view('modules.user.index', compact('result', 'roles'));        
    }

    public function create(Request $request)
    {
        $roles = $this->userService->getRoles();
        $permissionsGroups = $this->userService->getPermissions()->groupBy('type');

        if($request->ajax()) {
            $html = $this->userService->mergePermissionsRanderHTML($request);
            
            return response()->json($html);
        }

        return view('modules.user.create', compact('roles', 'permissionsGroups'));
    }

    public function store(CreateUserRequest $request)
    {
        if($this->userService->createUser($request)) {
            return redirect()->route('user.index')->with('success', 'User is created.');
        }

        return redirect()->route('user.index')->with('error', 'User is not created.');
    }

    public function edit(Request $request, $key)
    {
        $user = $this->userService->getUserByKey($key);
        $roles = $this->userService->getRoles();
        $permissions = $this->userService->getPermissions();
        $permissionsGroups = $permissions->groupBy('type');

        if($user->is_super == 1 || $user->hasRole('student')) {
            abort(404);
        }

        if($request->ajax()) {
            $html = $this->userService->mergePermissionsRanderHTML($request);
            return response()->json($html);
        }
        
        return view('modules.user.edit', compact('user', 'roles', 'permissions', 'permissionsGroups'));
    }

    public function update(UpdateUserRequest $request, $key)
    {
        if($this->userService->updateUser($request, $key)) {
            return redirect()->route('user.index')->with('success', 'User is updated.');
        }

        return redirect()->route('user.index')->with('error', 'User is not updated.');
    }

    public function show($key)
    {
        $user = $this->userService->getUserByKey($key);
        
        if($user->student) {
            abort(404);
        }

        return view('modules.user.show', compact('user'));        
    }
}
