<?php

namespace App\Interfaces;

interface StudentRepositoryInterface
{
    public function count($data);
    public function get($request);
    public function getById($id);
    public function getByKey($key);
    public function create($request, $user_id);
    public function update($request, $id);
    public function model();
}
