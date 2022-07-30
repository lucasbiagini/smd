<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements IUser
{
    public function paginateUsers($sortBy, $sortDirection, $perPage)
    {
        return User::orderBy($sortBy, $sortDirection)->paginate($perPage);
    }
}
