<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Repositories\User\IUser;

class UpdateUserController extends Controller
{
    private IUser $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function __invoke (UpdateUserRequest $request, User $user)
    {
        return $this->user->updateUser($user, $request->name, $request->status);
    }
}
