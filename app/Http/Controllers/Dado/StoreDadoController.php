<?php

namespace App\Http\Controllers\Dado;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dado\StoreDadoRequest;
use App\Repositories\Dado\IDado;

class StoreDadoController extends Controller
{
    private IDado $dado;

    public function __construct(IDado $dado)
    {
        $this->dado = $dado;
    }

    public function __invoke (StoreDadoRequest $request)
    {
        return $this->dado->store($request);
    }
}
