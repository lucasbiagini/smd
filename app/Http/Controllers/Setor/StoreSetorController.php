<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setor\StoreSetorRequest;
use App\Repositories\Setor\ISetor;

class StoreSetorController extends Controller
{
    private ISetor $setor;

    public function __construct(ISetor $setor)
    {
        $this->setor = $setor;
    }

    public function __invoke (StoreSetorRequest $request)
    {
        return $this->setor->store($request->name, $request->desc);
    }
}
