<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Repositories\Permission\IPermission;

class AllPermissionsController extends Controller
{
    private IPermission $permission;

    public function __construct(IPermission $permission)
    {
        $this->permission = $permission;
    }

    public function __invoke ()
    {
        return $this->permission->all();
    }
}
