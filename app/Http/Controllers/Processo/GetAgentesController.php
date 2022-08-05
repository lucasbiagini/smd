<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;

class GetAgentesController extends Controller
{
    public function __invoke (Processo $processo)
    {
        return $processo->agentes;
    }
}
