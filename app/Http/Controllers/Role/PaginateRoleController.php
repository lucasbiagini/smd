<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\PaginateRoleRequest;
use App\Repositories\Role\IRole;

class PaginateRoleController extends Controller
{
    private IRole $role;

    public function __construct(IRole $role)
    {
        $this->role = $role;
    }

    public function __invoke (PaginateRoleRequest $request)
    {
        return $this->role->paginateRoles($request->sortBy, $request->sortDirection, $request->perPage, $request->status);
    }
}
