<?php

namespace App\Repositories;

use App\Interfaces\ProgramRepositoryInterFace;
use App\Models\Program;

class ProgramRepository implements ProgramRepositoryInterFace
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;
        
        $programs = Program::select('*');

        $totalRecords = $this->count($programs);
        $programs = $programs->skip($skip)->take($perPage)->get();
        
        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'programs' => $programs,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($programs) {
        return $programs->count();
    }

    public function getById($id)
    {
        return Program::findOrFail($id);
    }

    public function getByKey($key)
    {
        return Program::where('key', $key)->firstOrFail();
    }

    public function create($request)
    {
        return Program::create([
            'name' => $request->name,
            'university_id' => $request->university
        ]);
    }

    public function update($request, $key)
    {
        $program = $this->getByKey($key);
        
        $program->update([
            'name' => $request->name,
            'university_id' => $request->university
        ]);

        return $program;
    }

    public function model()
    {
        return new Program();
    }
}
