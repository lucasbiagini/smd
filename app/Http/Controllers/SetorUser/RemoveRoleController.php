<?php

namespace App\Http\Controllers\SetorUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetorUser\RemoveRoleRequest;
use App\Models\SetorUser;
use App\Repositories\Role\IRole;
use App\Repositories\SetorUser\ISetorUser;

class RemoveRoleController extends Controller
{
    private ISetorUser $setor_user;
    private IRole $role;

    public function __construct(ISetorUser $setor_user, IRole $role)
    {
        $this->setor_user = $setor_user;
        $this->role = $role;
    }

    public function __invoke (RemoveRoleRequest $request, SetorUser $setor_user)
    {
        $role = $this->role->findById($request->role_id);
        if ($role->name === 'Administrador') {
            $count_other_adminstradores = SetorUser::where('setor_id', $setor_user->setor_id)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'Administrador');
                })
                ->count();

            if ($count_other_adminstradores === 1) return response([
                'message' => 'Não é possível remover o único Administrador do setor.'
            ], 422);
        }

        $setor_user->removeRole($role->name);
        $this->setor_user->deleteIfHasNoRole($setor_user);
    }
}
