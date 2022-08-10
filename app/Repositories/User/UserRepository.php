<?php

namespace App\Repositories\User;

use App\Models\SetorUser;
use App\Models\User;

class UserRepository implements IUser
{
    public function findById ($id)
    {
        return User::ofSetor()->find($id);
    }

    public function paginateUsers($sortBy, $sortDirection, $perPage, $status)
    {
        return User::ofSetor()->where(function($query) use ($status) {
            if (isset($status)) $query->where('status', $status);
        })->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function updateUser (User $user, $name, $status)
    {
        $user->update([
            'name' => $name,
            'status' => $status
        ]);

        return $user->save();
    }

    public function getRoles (User $user)
    {
        return SetorUser::ofSetor()->where('user_id', $user->id)->with('user', 'setor', 'roles')->get();
    }
}
