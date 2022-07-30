<?php

namespace App\Repositories\User;

use App\Models\User;

interface IUser
{
    public function findById($id);
    public function paginateUsers($sortBy, $sortDirection, $perPage);
    public function updateUser(User $user, $name, $status);
}
