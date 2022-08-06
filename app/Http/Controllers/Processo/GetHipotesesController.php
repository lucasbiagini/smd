<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;

class GetHipotesesController extends Controller
{
    public function __invoke ()
    {
        return Processo::HIPOTESES;
    }
}
