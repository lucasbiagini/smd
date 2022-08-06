<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operador\UpdateOperadorRequest;
use App\Models\Operador;
use App\Repositories\Operador\IOperador;

class UpdateOperadorController extends Controller
{
    private IOperador $operador;

    public function __construct(IOperador $operador)
    {
        $this->operador = $operador;
    }

    public function __invoke (Operador $operador, UpdateOperadorRequest $request)
    {
        $this->operador->updateAtuacao($operador, $request->prop, $request->value);
    }
}
