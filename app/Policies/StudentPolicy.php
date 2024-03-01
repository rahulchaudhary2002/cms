<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-student');
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-student');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-student');
    }
}
