<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Repositories\Role\IRole;

class StoreRoleController extends Controller
{
    private IRole $role;

    public function __construct(IRole $role)
    {
        $this->role = $role;
    }

    public function __invoke (StoreRoleRequest $request)
    {
        return $this->role->store($request->name, $request->desc);
    }
}
