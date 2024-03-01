<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-course');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-course');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-course');
    }
}
