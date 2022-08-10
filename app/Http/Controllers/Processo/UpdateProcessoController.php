<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\UpdateProcessoRequest;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class UpdateProcessoController extends Controller
{
    private IProcesso $processo;

    public function __construct(IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (UpdateProcessoRequest $request, Processo $processo)
    {
        return $this->processo->updateProcesso($processo, $request->name, $request->ref, $request->description);
    }
}
