<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class RejectProcessoController extends Controller
{
    protected IProcesso $processo;

    public function __construct(IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke(Processo $processo)
    {
        $this->processo->reject($processo);
    }
}
