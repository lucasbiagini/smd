<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;
use Illuminate\Http\Request;

class DeleteImageController extends Controller
{
    protected IProcesso $processo;

    public function __construct(IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke(Processo $processo)
    {
        $this->processo->deleteImage($processo);
    }
}
