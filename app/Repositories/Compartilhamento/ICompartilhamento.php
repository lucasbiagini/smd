<?php

namespace App\Repositories\Compartilhamento;

use App\Http\Requests\Compartilhamento\StoreCompartilhamentoRequest;
use App\Http\Requests\Compartilhamento\UpdateCompartilhamentoRequest;
use App\Models\Compartilhamento;

interface ICompartilhamento
{
    public function store(StoreCompartilhamentoRequest $request);
    public function delete(Compartilhamento $compartilhamento);
    public function update(Compartilhamento $compartilhamento, UpdateCompartilhamentoRequest $request);
}
