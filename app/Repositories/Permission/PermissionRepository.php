<?php

namespace App\Repositories\Permission;

use App\Models\Permission;

class PermissionRepository implements IPermission
{
    public function all ()
    {
        return Permission::all()->groupBy('group');
    }
}
