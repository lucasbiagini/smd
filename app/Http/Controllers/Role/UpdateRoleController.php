<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use App\Repositories\Role\IRole;

class UpdateRoleController extends Controller
{
    private IRole $role;

    public function __construct(IRole $role)
    {
        $this->role = $role;
    }

    public function __invoke (UpdateRoleRequest $request, Role $role)
    {
        return $this->role->updateRole($role, $request->name, $request->status);
    }
}
