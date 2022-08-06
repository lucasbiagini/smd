<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class DownloadFileController extends Controller
{
    public function __invoke (File $file)
    {
        return Storage::download($file->path, $file->filename);
    }
}
