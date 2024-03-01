<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignSemesterPolicy extends BasePolicy
{
    use HandlesAuthorization;
    
    public function create(User $user)
    {
        return $this->getPermission($user, 'assign-semester');
    }
}
