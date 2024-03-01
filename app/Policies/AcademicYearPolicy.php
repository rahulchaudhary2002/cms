<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicYearPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $this->getPermission($user, 'view-academic-year');   
    }

    public function create(User $user)
    {
        return $this->getPermission($user, 'create-academic-year');
    }

    public function update(User $user)
    {
        return $this->getPermission($user, 'update-academic-year');
    }
}
