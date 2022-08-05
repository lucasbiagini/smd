<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;

class GetProcessoController extends Controller
{
    public function __invoke (Processo $processo)
    {
        return $processo;
    }
}
