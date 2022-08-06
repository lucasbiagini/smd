<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\PaginateDadosRequest;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class PaginateDadosController extends Controller
{
    protected IProcesso $processo;

    public function __construct (IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo, PaginateDadosRequest $request)
    {
        return $this->processo->paginateDados($processo, $request->sortBy, $request->sortDirection, $request->perPage);
    }
}
