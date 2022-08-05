<?php

namespace App\Repositories\Agente;

use App\Models\Agente;

interface IAgente
{
    public function findByProcessoId($processo_id);
    public function update(Agente $agente, $prop, $value);
}
