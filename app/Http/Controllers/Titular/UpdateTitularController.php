<?php

namespace App\Http\Controllers\Titular;

use App\Http\Controllers\Controller;
use App\Http\Requests\Titular\UpdateTitularRequest;
use App\Models\Titular;
use App\Repositories\Titular\ITitular;

class UpdateTitularController extends Controller
{
    protected ITitular $titular;

    public function __construct(ITitular $titular)
    {
        $this->titular = $titular;
    }

    public function __invoke (Titular $titular, UpdateTitularRequest $request)
    {
        $this->titular->update($titular, $request);
    }
}
