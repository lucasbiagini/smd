<?php

namespace App\Http\Controllers\Transferencia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transferencia\StoreTransferenciaRequest;
use App\Repositories\Transferencia\ITransferencia;

class StoreTransferenciaController extends Controller
{
    private ITransferencia $transferencia;

    public function __construct(ITransferencia $transferencia)
    {
        $this->transferencia = $transferencia;
    }

    public function __invoke (StoreTransferenciaRequest $request)
    {
        return $this->transferencia->store($request);
    }
}
