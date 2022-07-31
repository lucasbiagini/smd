<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setor\SearchSetorRequest;
use App\Repositories\Setor\ISetor;

class SearchSetorController extends Controller
{
    private ISetor $setor;

    public function __construct(ISetor $setor)
    {
        $this->setor = $setor;
    }

    public function __invoke (SearchSetorRequest $request)
    {
        return $this->setor->searchSetor($request->only('query')['query']);
    }
}
