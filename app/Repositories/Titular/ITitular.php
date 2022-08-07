<?php

namespace App\Repositories\Titular;

use App\Http\Requests\Titular\StoreTitularRequest;
use App\Http\Requests\Titular\UpdateTitularRequest;
use App\Models\Titular;

interface ITitular
{
    public function getTiposSGD();
    public function store(StoreTitularRequest $request);
    public function delete(TItular $titular);
    public function update(TItular $titular, UpdateTitularRequest $request);
}
