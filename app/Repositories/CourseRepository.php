<?php

namespace App\Repositories;

use App\Interfaces\CourseRepositoryInterFace;
use App\Models\Course;

class CourseRepository implements CourseRepositoryInterFace
{
    public function getWithRelation($relation)
    {
        return Course::with($relation)->latest()->get();
    }

    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;
        
        $courses = Course::select('*');

        if ($request->name) {
            $courses = $courses->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->program) {
            $courses = $courses->whereHas('program', function ($query) use ($request) {
                return $query->where('key', $request->program);
            });

        }
        
        if($request->semester) {
            $courses = $courses->whereHas('semester', function ($query) use ($request) {
                return $query->where('key', $request->semester);
            }); 
        }

        $totalRecords = $this->count($courses);
        $courses = $courses->latest()->skip($skip)->take($perPage)->get();
        
        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'courses' => $courses,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($courses) {
        return $courses->count();
    }

    public function getById($id)
    {
        return Course::findOrFail($id);
    }

    public function getByKey($key)
    {
        return Course::where('key', $key)->firstOrFail();
    }

    public function create($request)
    {
        return Course::create([
            'name' => $request->name,
            'course_code' => $request->course_code,
            'program_id' => $request->program,
            'semester_id' => $request->semester,
            'elective' => $request->elective ?? 0,
            'credit' => $request->credit,
        ]);
    }

    public function update($request, $key)
    {
        $course = $this->getByKey($key);
        
        $course->update([
            'name' => $request->name,
            'course_code' => $request->course_code,
            'program_id' => $request->program,
            'semester_id' => $request->semester,
            'elective' => $request->elective ?? 0,
            'credit' => $request->credit,
        ]);

        return $course;
    }

    public function model()
    {
        return new Course();
    }
}
