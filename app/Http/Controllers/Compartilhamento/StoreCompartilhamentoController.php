<?php

namespace App\Http\Controllers\Compartilhamento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Compartilhamento\StoreCompartilhamentoRequest;
use App\Repositories\Compartilhamento\ICompartilhamento;

class StoreCompartilhamentoController extends Controller
{
    private ICompartilhamento $compartilhamento;

    public function __construct(ICompartilhamento $compartilhamento)
    {
        $this->compartilhamento = $compartilhamento;
    }

    public function __invoke (StoreCompartilhamentoRequest $request)
    {
        return $this->compartilhamento->store($request);
    }
}
