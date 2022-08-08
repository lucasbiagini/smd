<?php

namespace App\Repositories\Medida;

use App\Http\Requests\Medida\StoreMedidaRequest;
use App\Http\Requests\Medida\UpdateMedidaRequest;
use App\Models\Medida;

interface IMedida
{
    public function getTiposSGD();
    public function store(StoreMedidaRequest $request);
    public function delete(Medida $titular);
    public function update(Medida $titular, UpdateMedidaRequest $request);
}
