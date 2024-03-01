<?php

namespace App\Interfaces;
        
interface BaseInterface
{
    public function count($data);
    public function get($request);
    public function getById($id);
    public function getByKey($key);
    public function create($request);
    public function update($request, $key);
    public function model();
}
