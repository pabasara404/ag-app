<?php
// app/Services/FileService.php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileService
{
    /**
     * Store uploaded files and associate them with a given model.
     *
     * @param array $files
     * @param mixed $model
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public static function download($path, $name)
    {
        return Storage::download($path, $name);
    }

    /**
     * Store uploaded files and associate them with a given model.
     *
     * @param array $files
     * @param mixed $model
     * @return false|string
     */
    public static function upload(UploadedFile $file, $path)
    {
        $path = Storage::putFile($path, $file);

        return $path;
    }
}
