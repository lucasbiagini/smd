<?php

namespace App\Http\Controllers\Titular;

use App\Http\Controllers\Controller;
use App\Http\Requests\Titular\StoreTitularRequest;
use App\Repositories\Titular\ITitular;

class StoreTitularController extends Controller
{
    private ITitular $dado;

    public function __construct(ITitular $dado)
    {
        $this->dado = $dado;
    }

    public function __invoke (StoreTitularRequest $request)
    {
        return $this->dado->store($request);
    }
}
