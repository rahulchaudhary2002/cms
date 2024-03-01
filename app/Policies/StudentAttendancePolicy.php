<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentAttendancePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-attendance');
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'take-attendance');
    }
}
