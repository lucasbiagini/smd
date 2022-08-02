<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class ListRolePermissionsController extends Controller
{

    public function __invoke (Role $role)
    {
        return $role->permissions->pluck('name');
    }
}
