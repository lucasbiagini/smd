<?php

namespace App\Http\Controllers\Medida;

use App\Http\Controllers\Controller;
use App\Http\Requests\Medida\StoreMedidaRequest;
use App\Repositories\Medida\IMedida;

class StoreMedidaController extends Controller
{
    private IMedida $medida;

    public function __construct(IMedida $medida)
    {
        $this->medida = $medida;
    }

    public function __invoke (StoreMedidaRequest $request)
    {
        return $this->medida->store($request);
    }
}
