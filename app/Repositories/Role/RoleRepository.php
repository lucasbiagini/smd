<?php

namespace App\Repositories\Role;

use App\Models\Role;

class RoleRepository implements IRole
{
    public function paginateRoles ($sortBy, $sortDirection, $perPage)
    {
        return Role::whereNotIn('name', ['admin', 'Administrador'])
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function store ($name)
    {
        return Role::create([
            'name' => $name,
            'guard_name' => 'web'
        ]);
    }

    public function searchRole ($query)
    {
        return Role::where('name', 'like', "%$query%")->take(5)->get();
    }

    public function findById ($id)
    {
        return Role::find($id);
    }

    public function updateRole (Role $user, $name, $status)
    {
        $user->update([
            'name' => $name,
            'status' => $status
        ]);

        return $user->save();
    }

    public function findByName ($name)
    {
        return Role::where('name', $name)->first();
    }
}
