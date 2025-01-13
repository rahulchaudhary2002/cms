<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeetingPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-meeting');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-meeting');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-meeting');
    }

    public function delete(User $user)
    {
        return $this->getPermission($user, 'delete-meeting');
    }
}
