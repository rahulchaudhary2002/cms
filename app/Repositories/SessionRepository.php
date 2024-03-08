<?php

namespace App\Repositories;

use App\Interfaces\SessionRepositoryInterface;
use App\Models\Session;

class SessionRepository implements SessionRepositoryInterface
{
    public function getWithRelation($relation)
    {
        return Session::with($relation)->latest()->get();
    }

    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;

        $sessions = Session::select('*');

        if ($request->name) {
            $sessions = $sessions->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->academic_year) {
            $sessions = $sessions->whereHas('academicYear', function ($query) use ($request) {
                return $query->where('key', $request->academic_year);
            });
        }

        if ($request->program) {
            $sessions = $sessions->whereHas('program', function ($query) use ($request) {
                return $query->where('key', $request->program);
            });
        }

        if ($request->semester) {
            $sessions = $sessions->whereHas('semester', function ($query) use ($request) {
                return $query->where('key', $request->semester);
            });
        }

        $totalRecords = $this->count($sessions);
        $sessions = $sessions->latest()->skip($skip)->take($perPage)->get();

        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'sessions' => $sessions,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($sessions)
    {
        return $sessions->count();
    }

    public function getById($id)
    {
        return Session::findOrFail($id);
    }

    public function getByKey($key)
    {
        return Session::where('key', $key)->firstOrFail();
    }

    public function getByActive($academicYear, $semester)
    {
        return Session::where('is_active', 1)->where('academic_year_id', $academicYear)->where('semester_id', $semester)->first();
    }

    public function create($request)
    {
        return Session::create([
            'name' => $request->name,
            'academic_year_id' => $request->academic_year,
            'program_id' => $request->program,
            'semester_id' => $request->semester
        ]);
    }

    public function update($request, $key)
    {
        $session = $this->getByKey($key);

        $session->update([
            'name' => $request->name,
        ]);

        return $session;
    }

    public function model()
    {
        return new Session();
    }
}
