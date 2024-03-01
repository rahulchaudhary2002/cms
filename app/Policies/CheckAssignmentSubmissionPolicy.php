<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CheckAssignmentSubmissionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $this->getPermission($user, 'check-assignment');
    }
}
