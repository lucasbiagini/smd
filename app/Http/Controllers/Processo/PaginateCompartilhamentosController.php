<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\PaginateCompartilhamentosRequest;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class PaginateCompartilhamentosController extends Controller
{
    protected IProcesso $processo;

    public function __construct (IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo, PaginateCompartilhamentosRequest $request)
    {
        return $this->processo->paginateCompartilhamentos($processo, $request->sortBy, $request->sortDirection, $request->perPage);
    }
}
