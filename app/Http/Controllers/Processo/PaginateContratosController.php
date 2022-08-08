<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\PaginateContratosRequest;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class PaginateContratosController extends Controller
{
    protected IProcesso $processo;

    public function __construct (IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo, PaginateContratosRequest $request)
    {
        return $this->processo->paginateContratos($processo, $request->sortBy, $request->sortDirection, $request->perPage);
    }
}
