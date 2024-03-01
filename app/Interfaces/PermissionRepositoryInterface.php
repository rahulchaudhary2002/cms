<?php

namespace App\Interfaces;
        
interface PermissionRepositoryInterface extends BaseInterface
{
    public function getByIds($ids);
}
