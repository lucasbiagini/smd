<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Repositories\Setor\ISetor;

class AllSetoresController extends Controller
{
    private ISetor $permission;

    public function __construct(ISetor $permission)
    {
        $this->permission = $permission;
    }

    public function __invoke ()
    {
        return $this->permission->all();
    }
}
