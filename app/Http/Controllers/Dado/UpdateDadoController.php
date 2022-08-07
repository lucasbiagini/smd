<?php

namespace App\Http\Controllers\Dado;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dado\UpdateDadoRequest;
use App\Models\Dado;
use App\Repositories\Dado\IDado;

class UpdateDadoController extends Controller
{
    protected IDado $dado;

    public function __construct(IDado $dado)
    {
        $this->dado = $dado;
    }

    public function __invoke (Dado $dado, UpdateDadoRequest $request)
    {
        $this->dado->update($dado, $request);
    }
}
