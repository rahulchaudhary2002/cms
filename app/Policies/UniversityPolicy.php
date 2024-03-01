<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UniversityPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-university');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-university');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-university');
    }
}
