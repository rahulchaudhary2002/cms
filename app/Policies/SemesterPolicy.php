<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SemesterPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-semester');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-semester');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-semester');
    }
}
