<?php

namespace App\Repositories\User;

interface IUser
{
    public function paginateUsers($sortBy, $sortDirection, $perPage);
}
