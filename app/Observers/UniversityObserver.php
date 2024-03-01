<?php

namespace App\Observers;

use App\Models\University;

class UniversityObserver extends BaseObserver
{
    public function creating(University $university): void
    {
        $this->generateKey(University::class, $university);
    }
}
