<?php

namespace App\Http\Controllers\Dado;

use App\Http\Controllers\Controller;
use App\Models\Dado;
use App\Repositories\Dado\IDado;

class DeleteDadoController extends Controller
{
    protected IDado $dado;

    public function __construct(IDado $dado)
    {
        $this->dado = $dado;
    }

    public function __invoke(Dado $dado)
    {
        $this->dado->delete($dado);
    }
}
