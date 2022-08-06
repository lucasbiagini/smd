<?php

namespace App\Repositories\Operador;

use App\Models\Operador;

class OperadorRepository implements IOperador
{
    public function delete (Operador $operador)
    {
        $operador->agente->delete();
        $operador->delete();
    }

    public function updateAtuacao (Operador $operador, $prop, $value)
    {
        $operador->$prop = $value;
        $operador->save();
    }
}
