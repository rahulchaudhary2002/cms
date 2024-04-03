<?php

namespace App\Interfaces;
        
interface ExaminationRecordRepositoryInterface
{
    public function create($request, $examination_stage_id, $student_id);
}
