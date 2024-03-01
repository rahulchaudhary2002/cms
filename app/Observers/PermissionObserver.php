<?php

namespace App\Observers;

use App\Models\Permission;

class PermissionObserver extends BaseObserver
{
    public function creating(Permission $permission): void
    {
        $this->generateKey(Permission::class, $permission);
    }
}
