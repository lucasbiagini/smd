<?php

namespace App\Http\Controllers\Titular;

use App\Http\Controllers\Controller;
use App\Models\Titular;
use App\Repositories\Titular\ITitular;

class DeleteTitularController extends Controller
{
    protected ITitular $titular;

    public function __construct(ITitular $titular)
    {
        $this->titular = $titular;
    }

    public function __invoke(Titular $titular)
    {
        $this->titular->delete($titular);
    }
}
