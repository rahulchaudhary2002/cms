<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-assignment');
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-assignment');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-assignment');
    }

    public function viewAllSubmission(User $user)
    {
        return $this->getPermission($user, 'view-all-submission');
    }

    public function viewSubmission(User $user)
    {
        return $this->getPermission($user, 'view-submission');
    }

    public function submitAssignment(User $user)
    {
        return $this->getPermission($user, 'submit-assignment');
    }

    public function checkAssignment(User $user)
    {
        return $this->getPermission($user, 'check-assignment');
    }
}
