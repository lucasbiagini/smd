<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PaginateUserRequest;
use App\Repositories\User\IUser;

class PaginateUserController extends Controller
{
    private IUser $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function __invoke (PaginateUserRequest $request)
    {
        return $this->user->paginateUsers($request->sortBy, $request->sortDirection, $request->perPage, $request->statusUser);
    }
}
