<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\SyncRolePermissionsRequest;
use Spatie\Permission\Models\Role;

class SyncRolePermissionsController extends Controller
{

    public function __invoke (SyncRolePermissionsRequest $request, Role $role)
    {
        return $role->syncPermissions($request->permissions);
    }
}
