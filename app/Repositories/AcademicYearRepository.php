<?php

namespace App\Repositories;

use App\Interfaces\AcademicYearRepositoryInterface;
use App\Models\AcademicYear;

class AcademicYearRepository implements AcademicYearRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;
        
        $academicYears = AcademicYear::select('*');
        
        $totalRecords = $this->count($academicYears);
        $academicYears = $academicYears->latest()->skip($skip)->take($perPage)->get();
        
        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'academicYears' => $academicYears,
            'totalRecords' => $totalRecords
        ];
    }

    public function getWithSessions()
    {
        return AcademicYear::latest()->with('sessions')->get();
    }

    public function count($academicYears) {
        return $academicYears->count();
    }

    public function getById($id)
    {
        return AcademicYear::findOrFail($id);
    }

    public function getByKey($key)
    {
        return AcademicYear::where('key', $key)->firstOrFail();
    }

    public function create($request)
    {
        return AcademicYear::create([
            'name' => $request->name
        ]);
    }

    public function update($request, $key)
    {
        $academicYear = $this->getByKey($key);
        
        $academicYear->update([
            'name' => $request->name
        ]);
        return $academicYear;
    }

    public function model()
    {
        return new AcademicYear();
    }
}
