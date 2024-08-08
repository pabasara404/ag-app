<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class FileableController extends Controller
{
    abstract protected function getModel();

    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB Max
        ]);

        $model = $this->getModel()::findOrFail($id);
        $file = $model->addFile($request->file('file'));

        return response()->json($file);
    }

    public function deleteFile(Request $request, $id, $fileId)
    {
        $model = $this->getModel()::findOrFail($id);
        $model->deleteFile($fileId);

        return response()->noContent();
    }

    public function getFiles($id)
    {
        $model = $this->getModel()::findOrFail($id);
        return response()->json($model->files);
    }
}
