<?php

namespace App\Http\Controllers\Transferencia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transferencia\UpdateTransferenciaRequest;
use App\Models\Transferencia;
use App\Repositories\Transferencia\ITransferencia;

class UpdateTransferenciaController extends Controller
{
    protected ITransferencia $transferencia;

    public function __construct(ITransferencia $transferencia)
    {
        $this->transferencia = $transferencia;
    }

    public function __invoke (Transferencia $transferencia, UpdateTransferenciaRequest $request)
    {
        $this->transferencia->update($transferencia, $request);
    }
}
