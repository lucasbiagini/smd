<?php

namespace App\Repositories\Processo;

use App\Models\Processo;

interface IProcesso
{
    public function findById($id);
    public function paginateProcessos($sortBy, $sortDirection, $perPage);
    public function store($name, $ref, $setor_id);
}
