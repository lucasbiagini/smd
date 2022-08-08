<?php

namespace App\Http\Controllers\Medida;

use App\Http\Controllers\Controller;
use App\Models\Medida;
use App\Repositories\Medida\IMedida;

class DeleteMedidaController extends Controller
{
    protected IMedida $medida;

    public function __construct(IMedida $medida)
    {
        $this->medida = $medida;
    }

    public function __invoke(Medida $medida)
    {
        $this->medida->delete($medida);
    }
}
