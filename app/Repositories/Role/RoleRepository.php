<?php

namespace App\Repositories\Role;

use App\Models\Role;

class RoleRepository implements IRole
{
    public function paginateRoles ($sortBy, $sortDirection, $perPage)
    {
        return Role::orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function store ($name)
    {
        return Role::create([
            'name' => $name,
            'guard_name' => 'web'
        ]);
    }
}
