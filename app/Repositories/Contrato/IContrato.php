<?php

namespace App\Repositories\Contrato;

use App\Http\Requests\Contrato\StoreContratoRequest;
use App\Http\Requests\Contrato\UpdateContratoRequest;
use App\Models\Contrato;

interface IContrato
{
    public function store(StoreContratoRequest $request);
    public function delete(Contrato $compartilhamento);
    public function update(Contrato $compartilhamento, UpdateContratoRequest $request);
}
