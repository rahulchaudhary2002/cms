<?php

namespace App\Repositories;

use App\Interfaces\ExaminationStageRepositoryInterface;
use App\Models\ExaminationStage;

class ExaminationStageRepository implements ExaminationStageRepositoryInterface
{
    public function get($request)
    {
        $page = $request->page ?? 1;
        $perPage = $request->perPage ?? 10;
        $skip = ($page - 1) * $perPage;
        
        $examinationStages = ExaminationStage::select('*');

        if ($request->name) {
            $examinationStages = $examinationStages->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->academic_year) {
            $examinationStages = $examinationStages->whereHas('academicYear', function ($query) use ($request) {
                return $query->where('key', $request->academic_year);
            });
        }

        if ($request->program) {
            $examinationStages = $examinationStages->whereHas('program', function ($query) use ($request) {
                return $query->where('key', $request->program);
            });
        }

        if ($request->semester) {
            $examinationStages = $examinationStages->whereHas('semester', function ($query) use ($request) {
                return $query->where('key', $request->semester);
            });
        }

        if ($request->session) {
            $examinationStages = $examinationStages->whereHas('session', function ($query) use ($request) {
                return $query->where('key', $request->session);
            });
        }

        $totalRecords = $this->count($examinationStages);
        $examinationStages = $examinationStages->skip($skip)->take($perPage)->get();
        
        return [
            'currentPage' => $page,
            'recordsPerPage' => $perPage,
            'examinationStages' => $examinationStages,
            'totalRecords' => $totalRecords
        ];
    }

    public function count($examinationStages) {
        return $examinationStages->count();
    }

    public function getById($id)
    {
        return ExaminationStage::findOrFail($id);
    }

    public function getByKey($key)
    {
        return ExaminationStage::where('key', $key)->firstOrFail();
    }

    public function create($request)
    {
        return ExaminationStage::create([
            'name' => $request->name,
            'academic_year_id' => $request->academic_year,
            'program_id' => $request->program,
            'semester_id' => $request->semester,
            'session_id' => $request->session,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    }

    public function update($request, $key)
    {
        $examinationStage = $this->getByKey($key);
        
        $examinationStage->update([
            'name' => $request->name,
            'academic_year_id' => $request->academic_year,
            'program_id' => $request->program,
            'semester_id' => $request->semester,
            'session_id' => $request->session,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return $examinationStage;
    }

    public function model()
    {
        return new ExaminationStage();
    }
}
