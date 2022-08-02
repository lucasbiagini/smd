<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\IUser;

class GetUserRolesController extends Controller
{
    private IUser $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function __invoke (User $user)
    {
        return $this->user->getRoles($user);
    }
}
