<?php

namespace App\Repositories;

use App\Interfaces\StudentRepositoryInterface;
use App\Models\Student;
use App\Models\User;

class StudentRepository implements StudentRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $students = User::where('is_super', 0)->whereHas('roles', function ($query) {
            return $query->whereHas('role', function ($query) {
                return $query->where('key', 'student');
            });
        })->whereHas('student');

        if ($request->name) {
            $students = $students->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->academic_year) {
            $students = $students->whereHas('student', function ($query) use ($request) {
                return $query->whereHas('academicYear', function ($query) use ($request) {
                    return $query->where('key', $request->academic_year);
                });
            });
        }

        if ($request->program) {
            $students = $students->whereHas('student', function ($query) use ($request) {
                return $query->whereHas('program', function ($query) use ($request) {
                    return $query->where('key', $request->program);
                });
            });
        }

        if ($request->semester) {
            $students = $students->whereHas('student', function ($query) use ($request) {
                return $query->whereHas('semesters', function ($query) use ($request) {
                    return $query->whereHas('semester', function ($query) use ($request) {
                        return $query->where('key', $request->semester);
                    });
                });
            });
        }

        if ($request->session) {
            $students = $students->whereHas('student', function ($query) use ($request) {
                return $query->whereHas('semesters', function ($query) use ($request) {
                    return $query->whereHas('session', function ($query) use ($request) {
                        return $query->where('key', $request->session);
                    });
                });
            });
        }

        if ($request->course) {
            $students = $students->whereHas('student', function ($query) use ($request) {
                return $query->whereHas('studentCourses', function ($query) use ($request) {
                    return $query->whereHas('course', function ($query) use ($request) {
                        return $query->where('key', $request->course);
                    });
                });
            });
        }

        $totalRecords = $this->count($students);
        $students = $students->latest()->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'students' => $students,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($users)
    {
        return $users->count();
    }

    public function getById($id)
    {
        return User::findOrFail($id);
    }

    public function getByKey($key)
    {
        return User::where('key', $key)->firstOrFail();
    }

    public function create($request, $user_id)
    {
        Student::create([
            'user_id' => $user_id,
            'registration_number' => now()->year . $user_id,
            'academic_year_id' => $request->academic_year,
            'program_id' => $request->program,
        ]);

        return $this->getById($user_id);
    }

    public function update($request, $user_id)
    {
        $student = Student::where('user_id', $user_id)->first();

        // $student->update([

        // ]);

        return $this->getById($user_id);
    }

    public function model()
    {
        return new User();
    }
}
