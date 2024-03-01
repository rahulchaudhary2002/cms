<?php

namespace App\Repositories;

use App\Interfaces\TeacherRepositoryInterface;
use App\Models\Teacher;
use App\Models\User;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $users = User::where('is_super', 0)->whereHas('roles', function ($query) {
            return $query->whereHas('role', function ($query) {
                return $query->where('key', 'teacher');
            });
        })->whereHas('teacher');

        if ($request->name) {
            $users = $users->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->academic_year) {
            $users = $users->whereHas('teacher', function ($query) use ($request) {
                return $query->whereHas('teacherCourses', function ($query) use ($request) {
                    return $query->whereHas('course', function ($query) use ($request) {
                        return $query->whereHas('semester', function ($query) use ($request) {
                            return $query->whereHas('sessions', function ($query) use ($request) {
                                return $query->whereHas('academicYear', function ($query) use ($request) {
                                    return $query->where('key', $request->academic_year);
                                });
                            });
                        });
                    });
                });
            });
        }

        if ($request->session) {
            $users = $users->whereHas('teacher', function ($query) use ($request) {
                return $query->whereHas('teacherCourses', function ($query) use ($request) {
                    return $query->whereHas('course', function ($query) use ($request) {
                        return $query->whereHas('semester', function ($query) use ($request) {
                            return $query->whereHas('sessions', function ($query) use ($request) {
                                return $query->where('key', $request->session);
                            });
                        });
                    });
                });
            });
        }

        if ($request->course) {
            $users = $users->whereHas('teacher', function ($query) use ($request) {
                return $query->whereHas('teacherCourses', function ($query) use ($request) {
                    return $query->whereHas('course', function ($query) use ($request) {
                        return $query->where('key', $request->course);
                    });
                });
            });
        }

        $totalRecords = $this->count($users);
        $users = $users->latest()->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'users' => $users,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($users)
    {
        return $users->count();
    }

    public function create($request, $id)
    {
        return Teacher::create([
            'user_id' => $id
        ]);
    }

    public function update($request, $id)
    {
        return Teacher::where('user_id', $id)->update([
            'user_id' => $id
        ]);
    }

    public function getByKey($key)
    {
        return User::where('key', $key)->firstOrFail();
    }
}
