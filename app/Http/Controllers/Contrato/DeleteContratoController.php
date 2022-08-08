<?php

namespace App\Http\Controllers\Contrato;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Repositories\Contrato\IContrato;

class DeleteContratoController extends Controller
{
    protected IContrato $contrato;

    public function __construct(IContrato $contrato)
    {
        $this->contrato = $contrato;
    }

    public function __invoke(Contrato $contrato)
    {
        $this->contrato->delete($contrato);
    }
}
