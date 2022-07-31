<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\SearchRoleRequest;
use App\Repositories\Role\IRole;

class SearchRoleController extends Controller
{
    private IRole $role;

    public function __construct(IRole $role)
    {
        $this->role = $role;
    }

    public function __invoke (SearchRoleRequest $request)
    {
        return $this->role->searchRole($request->only('query')['query']);
    }
}
