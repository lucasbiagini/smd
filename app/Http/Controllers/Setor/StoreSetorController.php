<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setor\StoreSetorRequest;
use App\Repositories\Role\IRole;
use App\Repositories\Setor\ISetor;
use App\Repositories\SetorUser\ISetorUser;

class StoreSetorController extends Controller
{
    private ISetor $setor;
    private ISetorUser $setor_user;
    private IRole $role;

    public function __construct(ISetor $setor, ISetorUser $setor_user, IRole $role)
    {
        $this->setor = $setor;
        $this->setor_user = $setor_user;
        $this->role = $role;
    }

    public function __invoke (StoreSetorRequest $request)
    {
        $setor = $this->setor->store($request->name, $request->desc);
        $setor_user = $this->setor_user->findOrCreate($setor->id, auth()->user()->id);
        $role = $this->role->findByName('Administrador');
        $setor_user->assignRole($role->name);
    }
}
