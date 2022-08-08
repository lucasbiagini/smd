<?php

namespace App\Repositories\Contrato;

use App\Http\Requests\Contrato\StoreContratoRequest;
use App\Http\Requests\Contrato\UpdateContratoRequest;
use App\Models\Contrato;

class ContratoRepository implements IContrato
{
    public function store(StoreContratoRequest $request)
    {
        return Contrato::create($request->only('processo_id', 'numero', 'objeto', 'email'));
    }

    public function delete(Contrato $contrato)
    {
        $contrato->delete();
    }

    public function update(Contrato $contrato, UpdateContratoRequest $request)
    {
        $contrato->update($request->only(['numero', 'objeto', 'email']));
    }
}
