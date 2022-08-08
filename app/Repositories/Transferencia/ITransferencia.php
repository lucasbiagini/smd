<?php

namespace App\Repositories\Transferencia;

use App\Http\Requests\Transferencia\StoreTransferenciaRequest;
use App\Http\Requests\Transferencia\UpdateTransferenciaRequest;
use App\Models\Transferencia;

interface ITransferencia
{
    public function store(StoreTransferenciaRequest $request);
    public function delete(Transferencia $transferencia);
    public function update(Transferencia $transferencia, UpdateTransferenciaRequest $request);
    public function getGarantias();
}
