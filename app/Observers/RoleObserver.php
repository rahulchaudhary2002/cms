<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver extends BaseObserver
{
    public function creating(Role $role): void
    {
        $this->generateKey(Role::class, $role);
    }
}
