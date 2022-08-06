<?php

namespace App\Http\Controllers\Processo;

use App\Http\Controllers\Controller;
use App\Models\Processo;
use App\Repositories\File\IFile;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    private IFile $file;

    public function __construct(IFile $file)
    {
        $this->file = $file;
    }

    public function __invoke (Processo $processo, Request $request)
    {
        $uploadedFile = $request->file('file');
        $pathName = 'processos/' . $processo->id;
        $filename = $request->filename;
        $type = $uploadedFile->getType();
        $path = $uploadedFile->storeAs($pathName, $filename);
        $this->file->store($processo, $path, $filename, $type);
    }
}
