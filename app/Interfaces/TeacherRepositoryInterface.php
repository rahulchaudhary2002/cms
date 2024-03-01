<?php

namespace App\Interfaces;
        
interface TeacherRepositoryInterface
{
    public function get($request);
    public function create($request, $id);
    public function update($request, $id);
    public function getByKey($key);
}
