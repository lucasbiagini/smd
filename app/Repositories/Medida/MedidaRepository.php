<?php

namespace App\Repositories\Medida;

use App\Http\Requests\Medida\StoreMedidaRequest;
use App\Http\Requests\Medida\UpdateMedidaRequest;
use App\Models\Medida;
use App\Models\TipoMedidaSGD;

class MedidaRepository implements IMedida
{
    public function getTiposSGD()
    {
        return TipoMedidaSGD::TIPOS;
    }

    public function store(StoreMedidaRequest $request)
    {
        return Medida::create($request->only(['processo_id', 'tipo', 'desc']));
    }

    public function delete(Medida $titular)
    {
        $titular->delete();
    }

    public function update(Medida $titular, UpdateMedidaRequest $request)
    {
        $titular->update($request->only(['tipo', 'desc']));
    }
}
