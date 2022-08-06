<?php

namespace App\Repositories\Operador;

use App\Models\Operador;

interface IOperador
{
    public function delete(Operador $operador);
    public function updateAtuacao(Operador $operador, $prop, $value);
}
