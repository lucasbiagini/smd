<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agente\UpdateAgenteRequest;
use App\Models\Agente;
use App\Repositories\Agente\IAgente;

class UpdateAgenteController extends Controller
{
    private IAgente $agente;

    public function __construct(IAgente $agente)
    {
        $this->agente = $agente;
    }

    public function __invoke (Agente $agente, UpdateAgenteRequest $request)
    {
        return $this->agente->update($agente, $request->prop, $request->value);
    }
}
