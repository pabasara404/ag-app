<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasFiles
{
    public function addFile(UploadedFile $file)
    {
        $path = $file->store('uploads/' . $this->getTable());

        return $this->files()->create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    public function deleteFile($fileId)
    {
        $file = $this->files()->findOrFail($fileId);
        Storage::delete($file->path);
        $file->delete();
    }
}
