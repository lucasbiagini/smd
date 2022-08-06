<?php

namespace App\Repositories\File;

use App\Models\Processo;
use App\Models\File;

interface IFile
{
    public function store(Processo $processo, $path, $filename, $type);
    public function delete(File $file);
}
