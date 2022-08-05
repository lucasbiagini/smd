<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Models\Operador;
use App\Repositories\Operador\IOperador;
use App\Repositories\Processo\IProcesso;

class DeleteOperadorController extends Controller
{
    private IOperador $operador;
    private IProcesso $processo;

    public function __construct(IOperador $operador, IProcesso $processo)
    {
        $this->operador = $operador;
        $this->processo = $processo;
    }

    public function __invoke (Operador $operador)
    {
        $processo = $operador->processo;
        $this->operador->delete($operador);
        return $this->processo->getOperadores($processo);
    }
}
