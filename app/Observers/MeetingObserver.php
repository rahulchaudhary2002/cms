<?php

namespace App\Observers;

use App\Models\Meeting;

class MeetingObserver extends BaseObserver
{
    public function creating(Meeting $course): void
    {
        $this->generateKey(Meeting::class, $course);
    }
}
