<?php

namespace App\Repositories\Dado;

use App\Http\Requests\Dado\StoreDadoRequest;
use App\Http\Requests\Dado\UpdateDadoRequest;
use App\Models\Dado;

interface IDado
{
    public function getCategorias();
    public function getBasesSGD();
    public function getFontesSGD();
    public function store(StoreDadoRequest $request);
    public function delete(Dado $dado);
    public function update(Dado $dado, UpdateDadoRequest $request);
}
