<?php

namespace App\Repositories;

use App\Interfaces\ExaminationMarkRepositoryInterface;
use App\Models\ExaminationMark;

class ExaminationMarkRepository implements ExaminationMarkRepositoryInterface
{
    public function create($request, $recordId)
    {
        foreach ($request->courses as $key => $course) {
            ExaminationMark::create([
                'examination_record_id' => $recordId,
                'course_id' => $course,
                'grade' => $request->grades[$key]
            ]);
        }

        return true;
    }

    public function update($request, $recordId)
    {
        $this->delete($recordId);
        $this->create($request, $recordId);

        return true; 
    }

    public function delete($recordId)
    {
        return ExaminationMark::where('examination_record_id', $recordId)->delete();
    }
}
