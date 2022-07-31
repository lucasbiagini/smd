<?php

namespace App\Repositories\SetorUser;

interface ISetorUser
{
    public function findOrCreate($setor_id, $user_id);
    public function store($setor_id, $user_id);
    public function deleteIfHasNoRole($setor_user);
}
