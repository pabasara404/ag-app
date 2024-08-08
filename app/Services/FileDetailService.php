<?php
// app/Services/FileService.php
namespace App\Services;

use App\Http\Requests\StoreFileDetailRequest;
use App\Models\FileDetail;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileDetailService
{
    public static function store(array $fileDetail)
    {
        return FileDetail::create($fileDetail);
    }
}
