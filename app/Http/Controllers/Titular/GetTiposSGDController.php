<?php

namespace App\Http\Controllers\Titular;

use App\Http\Controllers\Controller;
use App\Repositories\Titular\ITitular;

class GetTiposSGDController extends Controller
{
    protected ITitular $titular;

    public function __construct (ITitular $titular)
    {
        $this->titular = $titular;
    }

    public function __invoke()
    {
        return $this->titular->getTiposSGD();
    }
}
