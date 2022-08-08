<?php

namespace App\Http\Controllers\Contrato;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contrato\UpdateContratoRequest;
use App\Models\Contrato;
use App\Repositories\Contrato\IContrato;

class UpdateContratoController extends Controller
{
    protected IContrato $contrato;

    public function __construct(IContrato $contrato)
    {
        $this->contrato = $contrato;
    }

    public function __invoke (Contrato $contrato, UpdateContratoRequest $request)
    {
        $this->contrato->update($contrato, $request);
    }
}
