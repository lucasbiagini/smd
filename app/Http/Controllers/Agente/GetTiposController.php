<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Repositories\Agente\IAgente;

class GetTiposController extends Controller
{
    private IAgente $agente;

    public function __construct(IAgente $agente)
    {
        $this->agente = $agente;
    }

    public function __invoke ()
    {
        return $this->agente->getTipos();
    }
}
