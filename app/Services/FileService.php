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
     * @return void
     */
    public function download(array $files, $model)
    {
        foreach ($files as $file) {
            $path = $file->store('uploads');
            File::create([
                'path' => $path,
                'fileable_id' => $model->id,
                'fileable_type' => get_class($model),
            ]);
        }
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
