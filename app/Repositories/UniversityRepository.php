<?php

namespace App\Repositories;

use App\Interfaces\UniversityRepositoryInterface;
use App\Models\University;

class UniversityRepository implements UniversityRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage; 
        
        $universities = University::select('*');

        $totalRecords = $this->count($universities);
        $universities = $universities->latest()->skip($skip)->take($perPage)->get();
        
        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'universities' => $universities,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($universities) {
        return $universities->count();
    }

    public function getById($id)
    {
        return University::findOrFail($id);
    }

    public function getByKey($key)
    {
        return University::where('key', $key)->firstOrFail();
    }

    public function create($request)
    {
        return University::create([
            'name' => $request->name
        ]);
    }

    public function update($request, $key)
    {
        $university = $this->getByKey($key);
        
        $university->update([
            'name' => $request->name
        ]);

        return $university;
    }

    public function model()
    {
        return new University();
    }
}
