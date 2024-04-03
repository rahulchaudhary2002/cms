<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExaminationRecordPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->getPermission($user, 'view-all-examination-record');   
    }

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-examination-record');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-examination-record');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-examination-record');
    }
}
