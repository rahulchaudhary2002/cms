<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    protected function getPermission($user, $permission_key)
    {
        foreach ($user->permissions as $userPermission) {
            if ($userPermission->permission->key == $permission_key) {
                return true;
            }
        }
        
        return false;
    }
}
