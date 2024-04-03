<?php

namespace App\Traits;
        
trait ExaminationStageTrait
{
    public function getExaminationStagesWithAcademicYearProgramSemesterAndSession()
    {
        return $this->examinationStageRepository->model()->with(['academicYear', 'program', 'semester', 'session'])->get();
    }
}
