<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\PaginateProcessoRequest;
use App\Repositories\Processo\IProcesso;

class PaginateProcessoController extends Controller
{
    private IProcesso $processo;

    public function __construct(IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (PaginateProcessoRequest $request)
    {
        return $this->processo->paginateProcessos($request->sortBy, $request->sortDirection, $request->perPage);
    }
}
