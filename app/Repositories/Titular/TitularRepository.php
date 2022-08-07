<?php

namespace App\Repositories\Titular;

use App\Http\Requests\Titular\StoreTitularRequest;
use App\Http\Requests\Titular\UpdateTitularRequest;
use App\Models\Titular;
use App\Models\TipoSGD;

class TitularRepository implements ITitular
{
    public function getTiposSGD()
    {
        return TipoSGD::TIPOS;
    }

    public function store(StoreTitularRequest $request)
    {
        return Titular::create($request->only(['processo_id', 'tipo', 'desc']));
    }

    public function delete(Titular $titular)
    {
        $titular->delete();
    }

    public function update(Titular $titular, UpdateTitularRequest $request)
    {
        $titular->update($request->only(['tipo', 'desc']));
    }
}
