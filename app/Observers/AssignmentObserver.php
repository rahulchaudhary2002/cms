<?php

namespace App\Observers;

use App\Models\Assignment;

class AssignmentObserver extends BaseObserver
{
    public function creating(Assignment $assignment): void
    {
        $this->generateKey(Assignment::class, $assignment);
        $assignment->created_by = auth()->user()->id;
    }   
}
