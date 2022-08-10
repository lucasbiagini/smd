<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Processo\StoreProcessoRequest;
use App\Repositories\Processo\IProcesso;

class StoreProcessoController extends Controller
{
    private IProcesso $processo;

    public function __construct(IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (StoreProcessoRequest $request)
    {
        if (!session()->has('setor_id')) return response(['message' => 'Setor indefinido'], 400);
        $setor_id = session('setor_id');
        return $this->processo->store($request->name, $request->ref, $request->description, $setor_id);
    }
}
