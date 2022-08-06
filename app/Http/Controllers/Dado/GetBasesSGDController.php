<?php

namespace App\Http\Controllers\Dado;

use App\Http\Controllers\Controller;
use App\Repositories\Dado\IDado;

class GetBasesSGDController extends Controller
{
    protected IDado $dado;

    public function __construct (IDado $dado)
    {
        $this->dado = $dado;
    }

    public function __invoke()
    {
        return $this->dado->getBasesSGD();
    }
}
