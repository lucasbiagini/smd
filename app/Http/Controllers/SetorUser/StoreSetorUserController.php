<?php

namespace App\Http\Controllers\SetorUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetorUser\StoreSetorUserRequest;
use App\Repositories\Role\IRole;
use App\Repositories\SetorUser\ISetorUser;

class StoreSetorUserController extends Controller
{
    private ISetorUser $setor_user;
    private IRole $role;

    public function __construct(ISetorUser $setor_user, IRole $role)
    {
        $this->setor_user = $setor_user;
        $this->role = $role;
    }

    public function __invoke (StoreSetorUserRequest $request)
    {
        $setor_user = $this->setor_user->findOrCreate($request->setor_id, $request->user_id);
        $role = $this->role->findById($request->role_id);
        $setor_user->assignRole($role->name);
    }
}
