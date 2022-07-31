<?php

namespace App\Repositories\Role;

interface IRole
{
    public function paginateRoles($sortBy, $sortDirection, $perPage);
    public function store($name);
}
