<?php

namespace App\Http\Controllers\Contrato;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contrato\StoreContratoRequest;
use App\Repositories\Contrato\IContrato;

class StoreContratoController extends Controller
{
    private IContrato $contrato;

    public function __construct(IContrato $contrato)
    {
        $this->contrato = $contrato;
    }

    public function __invoke (StoreContratoRequest $request)
    {
        return $this->contrato->store($request);
    }
}
