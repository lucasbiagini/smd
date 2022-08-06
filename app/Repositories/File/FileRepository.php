<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Models\Processo;
use Illuminate\Support\Facades\Storage;

class FileRepository implements IFile
{
    public function store (Processo $processo, $path, $filename, $type)
    {
        File::create([
            'processo_id' => $processo->id,
            'path' => $path,
            'filename' => $filename,
            'type' => $type
        ]);
    }

    public function delete (File $file)
    {
        Storage::delete($file->path);
        $file->delete();
    }
}
