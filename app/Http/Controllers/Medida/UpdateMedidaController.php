<?php

namespace App\Http\Controllers\Medida;

use App\Http\Controllers\Controller;
use App\Http\Requests\Medida\UpdateMedidaRequest;
use App\Models\Medida;
use App\Repositories\Medida\IMedida;

class UpdateMedidaController extends Controller
{
    protected IMedida $medida;

    public function __construct(IMedida $medida)
    {
        $this->medida = $medida;
    }

    public function __invoke (Medida $medida, UpdateMedidaRequest $request)
    {
        $this->medida->update($medida, $request);
    }
}
