<?php

namespace App\Http\Controllers\Transferencia;

use App\Http\Controllers\Controller;
use App\Models\Transferencia;
use App\Repositories\Transferencia\ITransferencia;

class DeleteTransferenciaController extends Controller
{
    protected ITransferencia $transferencia;

    public function __construct(ITransferencia $transferencia)
    {
        $this->transferencia = $transferencia;
    }

    public function __invoke(Transferencia $transferencia)
    {
        $this->transferencia->delete($transferencia);
    }
}
