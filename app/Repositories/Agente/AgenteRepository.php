<?php

namespace App\Repositories\Agente;

use App\Models\Agente;

class AgenteRepository implements IAgente
{
    public function findByProcessoId ($processo_id)
    {
        return Agente::where('processo_id', $processo_id)->get();
    }

    public function update ($agente, $prop, $value)
    {
        $agente->update([
            $prop => $value !== "" ? $value : null
        ]);
    }
}
