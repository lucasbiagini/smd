<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\PaginateTitularesRequest;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class PaginateTitularesController extends Controller
{
    protected IProcesso $processo;

    public function __construct (IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo, PaginateTitularesRequest $request)
    {
        return $this->processo->paginateTitulares($processo, $request->sortBy, $request->sortDirection, $request->perPage);
    }
}
