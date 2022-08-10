<?php

namespace App\Repositories\Role;

use App\Models\Role;

class RoleRepository implements IRole
{
    public function paginateRoles ($sortBy, $sortDirection, $perPage, $status)
    {
        return Role::whereNotIn('name', ['admin', 'Administrador'])
            ->where(function ($query) use ($status) {
                if (isset($status)) $query->where('status', $status);
            })
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

    public function updateRole (Role $role, $name, $status)
    {
        $role->update([
            'name' => $name,
            'status' => $status
        ]);

        return $role->save();
    }

    public function findByName ($name)
    {
        return Role::where('name', $name)->first();
    }
}
