<?php

namespace App\Http\Controllers\Compartilhamento;

use App\Http\Controllers\Controller;
use App\Http\Requests\Compartilhamento\UpdateCompartilhamentoRequest;
use App\Models\Compartilhamento;
use App\Repositories\Compartilhamento\ICompartilhamento;

class UpdateCompartilhamentoController extends Controller
{
    protected ICompartilhamento $compartilhamento;

    public function __construct(ICompartilhamento $compartilhamento)
    {
        $this->compartilhamento = $compartilhamento;
    }

    public function __invoke (Compartilhamento $compartilhamento, UpdateCompartilhamentoRequest $request)
    {
        $this->compartilhamento->update($compartilhamento, $request);
    }
}
