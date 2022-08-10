<?php

namespace App\Http\Controllers\Setor;

use App\Http\Controllers\Controller;
use App\Models\Setor;
use App\Repositories\Setor\ISetor;

class SelectTodosSetoresController extends Controller
{

    public function __invoke ()
    {
        if (auth()->user()->hasRole('admin')) session(['setor_id' => -1, 'setor_name' => 'Todos']);
        return redirect()->back();
    }
}
