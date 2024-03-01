<?php

namespace App\Repositories;

use App\Interfaces\SemesterRepositoryInterFace;
use App\Models\Semester;

class SemesterRepository implements SemesterRepositoryInterFace
{
    public function getWithRelation($relation)
    {
        return Semester::with($relation)->get();
    }

    public function getByProgramAndOrder($program, $order)
    {
        return Semester::where('program_id', $program)->where('order', $order)->firstOrFail();
    }

    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $semesters = Semester::select('*');

        if ($request->name) {
            $semesters = $semesters->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->program) {
            $semesters = $semesters->whereHas('program', function ($query) use ($request) {
                return $query->where('key', $request->program);
            });
        }

        $totalRecords = $this->count($semesters);
        $semesters = $semesters->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'semesters' => $semesters,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($semesters)
    {
        return $semesters->count();
    }

    public function getById($id)
    {
        return Semester::findOrFail($id);
    }

    public function getByKey($key)
    {
        return Semester::where('key', $key)->firstOrFail();
    }

    public function create($request)
    {
        return Semester::create([
            'name' => $request->name,
            'program_id' => $request->program,
            'order' => $request->order,
            'number_of_elective_courses' => $request->number_of_elective_courses,
        ]);
    }

    public function update($request, $key)
    {
        $semester = $this->getByKey($key);

        $semester->update([
            'name' => $request->name,
            'program_id' => $request->program,
            'order' => $request->order,
            'number_of_elective_courses' => $request->number_of_elective_courses,
        ]);

        return $semester;
    }

    public function model()
    {
        return new Semester();
    }
}
