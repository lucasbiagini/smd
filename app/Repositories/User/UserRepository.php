<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements IUser
{
    public function findById ($id)
    {
        return User::find($id);
    }

    public function paginateUsers($sortBy, $sortDirection, $perPage)
    {
        return User::orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function updateUser (User $user, $name, $status)
    {
        $user->update([
            'name' => $name,
            'status' => $status
        ]);

        return $user->save();
    }
}
