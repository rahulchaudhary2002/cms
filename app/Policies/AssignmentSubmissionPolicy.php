<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentSubmissionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->getPermission($user, 'view-all-submission');
    }

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-submission');
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'submit-assignment');
    }
}
