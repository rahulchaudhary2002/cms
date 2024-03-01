<?php

namespace App\Observers;

use App\Models\User;

class UserObserver extends BaseObserver
{
    public function creating(User $user): void
    {
        $this->generateKey(User::class, $user);
    }
}
