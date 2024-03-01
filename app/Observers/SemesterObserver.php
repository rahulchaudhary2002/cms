<?php

namespace App\Observers;

use App\Models\Semester;

class SemesterObserver extends BaseObserver
{
    public function creating(Semester $semester): void
    {
        $this->generateKey(Semester::class, $semester);
    }
}
