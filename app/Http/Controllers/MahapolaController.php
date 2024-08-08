<?php

namespace App\Http\Controllers;

use App\Actions\MahapolaAction;
use App\Actions\PresidentFundAction;
use App\Http\Resources\MahapolaResource;
use App\Models\FileDetail;
use App\Models\Mahapola;
use App\Http\Requests\StoreMahapolaRequest;
use App\Http\Requests\UpdateMahapolaRequest;
use App\Models\PresidentFund;
use App\Services\FileDetailService;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahapolaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahapolas = Mahapola::with('gn_division')->get();
        return MahapolaResource::collection($mahapolas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMahapolaRequest $request)
    {
        return MahapolaAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $mahapola = Mahapola::findOrFail($id);
        return response()->json(['data' => $mahapola]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahapola $mahapola)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMahapolaRequest $request, $id)
    {
        $mahapola = Mahapola::findOrFail($id);
        $mahapola->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mahapola = Mahapola::findOrFail($id);
        $mahapola->delete();
        return response()->noContent();
    }

    public function updateStatus(Request $request, $id)
    {
        $mahapola = Mahapola::findOrFail($id);
        $mahapola->status = $request->status;
        $mahapola->save();
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function filterByStatus(Request $request): JsonResponse
    {
        $statuses = $request->query('statuses', '');

        if (empty($statuses)) {
            return response()->json(['error' => 'Statuses parameter is required'], 400);
        }

        $mahapolas = MahapolaAction::getApplicationByStatus($statuses);
        return response()->json(['data' => $mahapolas]);
    }

    public function upload(Request $request){
        $path = FileService::upload($request->file, 'mahapola');

        FileDetailService::store([
            'name' => $path,
            'path' => $path,
            'type' => $request->file->getMimeType(),
        ]);

//        Mahapola::

    }
}
