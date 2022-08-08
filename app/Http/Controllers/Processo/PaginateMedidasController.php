<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\PaginateMedidasRequest;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class PaginateMedidasController extends Controller
{
    protected IProcesso $processo;

    public function __construct (IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo, PaginateMedidasRequest $request)
    {
        return $this->processo->paginateMedidas($processo, $request->sortBy, $request->sortDirection, $request->perPage);
    }
}
