<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setor\PaginateSetorRequest;
use App\Repositories\Setor\ISetor;

class PaginateSetorController extends Controller
{
    private ISetor $setor;

    public function __construct(ISetor $setor)
    {
        $this->setor = $setor;
    }

    public function __invoke (PaginateSetorRequest $request)
    {
        return $this->setor->paginateSetores($request->sortBy, $request->sortDirection, $request->perPage, $request->status);
    }
}
