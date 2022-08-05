<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class AddOperadorController extends Controller
{
    private IProcesso $processo;

    public function __construct (IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo)
    {
        $this->processo->addOperador($processo);
        return $this->processo->getOperadores($processo);
    }
}
