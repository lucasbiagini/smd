<?php

namespace App\Repositories\SetorUser;

use App\Models\SetorUser;

class SetorUserRepository implements ISetorUser
{
    public function findOrCreate($setor_id, $user_id)
    {
        $setor_user = SetorUser::ofSetor()->where('setor_id', $setor_id)
            ->where('user_id', $user_id)
            ->first();

        return $setor_user ?? $this->store($setor_id, $user_id);
    }

    public function store ($setor_id, $user_id)
    {
        return SetorUser::create([
            'setor_id' => $setor_id,
            'user_id' => $user_id
        ]);
    }

    public function deleteIfHasNoRole ($setor_user)
    {
        $roles = $setor_user->roles;
        if (sizeof($roles) === 0) $setor_user->delete();
    }
}
