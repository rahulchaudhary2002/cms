<?php

namespace App\Interfaces;
        
interface RoleRepositoryInterface extends BaseInterface
{
    public function getByIds($ids);
}
