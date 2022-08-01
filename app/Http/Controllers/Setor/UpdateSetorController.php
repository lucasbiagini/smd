<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setor\UpdateSetorRequest;
use App\Models\Setor;
use App\Repositories\Setor\ISetor;

class UpdateSetorController extends Controller
{
    private ISetor $setor;

    public function __construct(ISetor $setor)
    {
        $this->setor = $setor;
    }

    public function __invoke (UpdateSetorRequest $request, Setor $setor)
    {
        return $this->setor->updateSetor($setor, $request->name, $request->status);
    }
}
