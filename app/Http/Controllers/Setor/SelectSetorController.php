<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Models\Setor;
use App\Repositories\Setor\ISetor;

class SelectSetorController extends Controller
{

    public function __invoke (Setor $setor)
    {
        if (auth()->user()->hasSetor($setor)) session(['setor_id' => $setor->id, 'setor_name' => $setor->name]);
        return redirect('/');
    }
}
