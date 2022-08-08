<?php

namespace App\Http\Controllers\Transferencia;

use App\Http\Controllers\Controller;
use App\Repositories\Transferencia\ITransferencia;

class GetGarantiasController extends Controller
{
    protected ITransferencia $transferencia;

    public function __construct (ITransferencia $transferencia)
    {
        $this->transferencia = $transferencia;
    }

    public function __invoke()
    {
        return $this->transferencia->getGarantias();
    }
}
