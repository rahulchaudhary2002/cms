<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-program');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-program');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-program');
    }
}
