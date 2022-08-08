<?php

namespace App\Http\Controllers\Medida;

use App\Http\Controllers\Controller;
use App\Repositories\Medida\IMedida;

class GetTiposMedidaSGDController extends Controller
{
    protected IMedida $medida;

    public function __construct (IMedida $medida)
    {
        $this->medida = $medida;
    }

    public function __invoke()
    {
        return $this->medida->getTiposSGD();
    }
}
