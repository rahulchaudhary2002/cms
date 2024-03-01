<?php

namespace App\Interfaces;

interface UserRepositoryInterface extends BaseInterface
{
    public function getByIds($ids);
}
