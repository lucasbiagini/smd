<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;

class GetFilesController extends Controller
{
    private IProcesso $processo;

    public function __construct(IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke (Processo $processo)
    {
        return $this->processo->getFiles($processo);
    }
}
