<?php

namespace App\Repositories\Role;

use App\Models\Role;

interface IRole
{
    public function paginateRoles($sortBy, $sortDirection, $perPage, $status);
    public function store($name);
    public function searchRole($query);
    public function findById($id);
    public function updateRole(Role $setor, $name, $status);
    public function findByName($name);
}
