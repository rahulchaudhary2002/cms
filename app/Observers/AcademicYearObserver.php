<?php

namespace App\Observers;

use App\Models\AcademicYear;

class AcademicYearObserver extends BaseObserver
{
    public function creating(AcademicYear $academicYear): void
    {
        $this->generateKey(AcademicYear::class, $academicYear);
    }
}
