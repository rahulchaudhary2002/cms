<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-session');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-session');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-session');
    }
}
