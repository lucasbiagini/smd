<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\PaginateTransferenciasRequest;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class PaginateTransferenciasController extends Controller
{
    protected IProcesso $processo;

    public function __construct (IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo, PaginateTransferenciasRequest $request)
    {
        return $this->processo->paginateTransferencias($processo, $request->sortBy, $request->sortDirection, $request->perPage);
    }
}
