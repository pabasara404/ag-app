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
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class MahapolaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahapolas = Mahapola::with('gn_division', 'user')->get();
        return MahapolaResource::collection($mahapolas);
    }

    /**
     * Display a listing of the resource for the authenticated user.
     *
     * @return AnonymousResourceCollection
     */
    public function userApplications()
    {
        $userId = auth()->id();

        $applications = Mahapola::with(
            "gn_division",
            "user"
        )->where('user_id', $userId)->get();

        return MahapolaResource::collection($applications);
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

    public function filterByStatus(Request $request): AnonymousResourceCollection
    {
        $statuses = $request->query('statuses', '');

        if (empty($statuses)) {
            return MahapolaResource::collection(collect());
        }

        $mahapolas = MahapolaAction::getApplicationByStatus($statuses);
        return MahapolaResource::collection($mahapolas);
    }


    public function upload(Request $request){
        $path = FileService::upload($request->file, 'mahapola');

        $fileDetail = FileDetailService::store([
            'name' => $request->file->getClientOriginalName(),
            'path' => $path,
            'type' => $request->file->getMimeType(),
        ]);

        $mahapola = Mahapola::findOrFail($request->id);

        if (!$mahapola->file_detail_ids){
            dump($mahapola->file_detail_ids);
            $mahapola->update(
                ['file_detail_ids'=> [$fileDetail->id]]
            );

            return response()->noContent();
        }

        $mahapola->update(
            ['file_detail_ids'=> [...Json::decode($mahapola->file_detail_ids), $fileDetail->id]]
        );

        return response()->noContent();
    }

    public function download(Request $request): string
    {
        $path = storage_path() . '/app/' . $request->path;
        return response()->download($path);
    }
}
