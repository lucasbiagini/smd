<?php

namespace App\Http\Controllers\Compartilhamento;

use App\Http\Controllers\Controller;
use App\Models\Compartilhamento;
use App\Repositories\Compartilhamento\ICompartilhamento;

class DeleteCompartilhamentoController extends Controller
{
    protected ICompartilhamento $compartilhamento;

    public function __construct(ICompartilhamento $compartilhamento)
    {
        $this->compartilhamento = $compartilhamento;
    }

    public function __invoke(Compartilhamento $compartilhamento)
    {
        $this->compartilhamento->delete($compartilhamento);
    }
}
