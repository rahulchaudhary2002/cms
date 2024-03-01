<?php

namespace App\Observers;

use App\Models\Session;

class SessionObserver extends BaseObserver
{
    public function creating(Session $session): void
    {
        Session::where('is_active', 1)->where('academic_year_id', $session->academic_year_id)->where('program_id', $session->program_id)->update([
            'is_active' => 0,
        ]);

        $session->is_active = 1;

        $this->generateKey(Session::class, $session);
    }
}
