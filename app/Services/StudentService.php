<?php

namespace App\Services;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Interfaces\PermissionRepositoryInterface;
use App\Interfaces\ProgramRepositoryInterFace;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\SemesterRepositoryInterFace;
use App\Interfaces\SessionRepositoryInterface;
use App\Interfaces\StudentRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Traits\AcademicYearTrait;
use App\Traits\ProgramTrait;
use App\Traits\SemesterTrait;
use App\Traits\SessionTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class StudentService
{
    use AcademicYearTrait, ProgramTrait, SemesterTrait, SessionTrait;
    
    private StudentRepositoryInterface $studentRepository;
    private UserRepositoryInterface $userRepository;
    private RoleRepositoryInterface $roleRepository;
    private PermissionRepositoryInterface $permissionRepository;
    private AcademicYearRepositoryInterface $academicYearRepository;
    private ProgramRepositoryInterFace $programRepository;
    private SemesterRepositoryInterFace $semesterRepository;
    private SessionRepositoryInterface $sessionRepository;

    public function __construct(StudentRepositoryInterface $studentRepository, UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository, AcademicYearRepositoryInterface $academicYearRepository, ProgramRepositoryInterFace $programRepository, SemesterRepositoryInterFace $semesterRepository, SessionRepositoryInterface $sessionRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->programRepository = $programRepository;
        $this->semesterRepository = $semesterRepository;
        $this->sessionRepository = $sessionRepository;
    }

    public function getStudents($request)
    {
        return $this->studentRepository->get($request);
    }

    public function getStudentByKey($key)
    {
        return $this->studentRepository->getByKey($key);
    }

    public function createStudent($request)
    {
        try {
            $student = null;

            DB::transaction(function () use ($request, &$student) {
                $user = $this->userRepository->create($request);
                $student = $this->studentRepository->create($request, $user->id);
                $student = $this->assignRolePermission($request, $student);
            });

            return $student;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateStudent($request, $key)
    {
        try {
            $student = null;

            DB::transaction(function () use ($request, $key, &$student) {
                $user = $this->userRepository->update($request, $key);
                $student = $this->studentRepository->update($request, $user->id);
                $student->detach($student->permissions, $student->roles) ?? '';
                $student = $this->assignRolePermission($request, $student);
            });

            return $student;
        } catch (Exception $e) {
            return false;
        }
    }

    public function assignRolePermission($request, $student)
    {
        $student->assignRole($this->roleRepository->getById($request->role)->key);

        if ($request->permissions) {
            $permissionIds = $request->permissions;
            $permissions = $this->permissionRepository->getByIds($permissionIds);
            $student->givePermissionTo($permissions);
        }

        return $student;
    }

    public function mergePermissionsRanderHTML($request)
    {
        $permissionsViaRole = $this->getPermissionsViaRole($request)->pluck('id')->toArray();
        $permissions = $this->getPermissions();
        $permissionsGroups = $permissions->groupBy('type');

        return view('includes.bulk-permission-checkbox', compact('permissionsViaRole', 'permissions', 'permissionsGroups'))->render();
    }

    public function getPermissionsViaRole($request)
    {
        $role = $this->roleRepository->getById($request->id);
        return $role->permissions;
    }

    public function getRoleByKey($key)
    {
        return $this->roleRepository->getByKey($key);
    }

    public function getPermissions()
    {
        return $this->permissionRepository->model()->get();
    }
}
