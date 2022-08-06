<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Repositories\File\IFile;

class DeleteFileController extends Controller
{
    private IFile $file;

    public function __construct(IFile $file)
    {
        $this->file = $file;
    }

    public function __invoke (File $file)
    {
        $this->file->delete($file);
    }
}
