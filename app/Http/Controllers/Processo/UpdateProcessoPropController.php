<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\UpdateProcessoPropRequest;
use App\Http\Requests\Processo\UpdateProcessoRequest;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class UpdateProcessoPropController extends Controller
{
    private IProcesso $processo;

    public function __construct(IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo, UpdateProcessoPropRequest $request)
    {
        return $this->processo->updateProcessoProp($processo, $request->prop, $request->value);
    }
}
