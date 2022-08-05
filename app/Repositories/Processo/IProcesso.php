<?php

namespace App\Repositories\Processo;

use App\Models\Processo;

interface IProcesso
{
    public function findById($id);
    public function paginateProcessos($sortBy, $sortDirection, $perPage);
    public function store($name, $ref, $setor_id);
    public function updateProcesso(Processo $processo, $name, $ref);
    public function addOperador(Processo $processo);
    public function getOperadores(Processo $processo);
}
