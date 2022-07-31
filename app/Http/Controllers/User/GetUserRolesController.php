<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\SetorUser\ISetorUser;
use App\Repositories\User\IUser;

class GetUserRolesController extends Controller
{
    private IUser $user;
    private ISetorUser $setor_user;

    public function __construct(IUser $user, ISetorUser $setor_user)
    {
        $this->user = $user;
        $this->setor_user = $setor_user;
    }

    public function __invoke (User $user)
    {
        return $this->user->getRoles($user);
    }
}
