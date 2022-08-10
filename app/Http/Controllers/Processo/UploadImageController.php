<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;
use App\Repositories\Processo\IProcesso;
use Illuminate\Http\Request;

class UploadImageController extends Controller
{
    protected IProcesso $processo;

    public function __construct(IProcesso $processo)
    {
        $this->processo = $processo;
    }

    public function __invoke(Processo $processo, Request $request)
    {
        $uploadedFile = $request->file('file');
        $pathName = 'public/processos/' . $processo->id . '/image';
        $filename = $request->filename;
        $type = $uploadedFile->getType();
        $path = $uploadedFile->storeAs($pathName, $filename);
        $this->processo->uploadImage($processo, $path, $filename, $type);
    }
}
