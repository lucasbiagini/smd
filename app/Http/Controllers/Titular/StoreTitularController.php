<?php

namespace App\Http\Controllers\Titular;

use App\Http\Controllers\Controller;
use App\Http\Requests\Titular\StoreTitularRequest;
use App\Repositories\Titular\ITitular;

class StoreTitularController extends Controller
{
    private ITitular $titular;

    public function __construct(ITitular $titular)
    {
        $this->titular = $titular;
    }

    public function __invoke (StoreTitularRequest $request)
    {
        return $this->titular->store($request);
    }
}
