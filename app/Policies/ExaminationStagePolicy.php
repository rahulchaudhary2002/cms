<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExaminationStagePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-examination-stage');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-examination-stage');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-examination-stage');
    }
}
