<?php

namespace App\Http\Controllers;

use App\Actions\FirmAction;
use App\Http\Resources\FirmResource;
use App\Models\Firm;
use App\Http\Requests\StoreFirmRequest;
use App\Http\Requests\UpdateFirmRequest;
use App\Http\Requests\SearchFirmRequest;
use App\Models\IndividualBusiness;
use App\Models\OtherPartneredBusiness;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FirmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $firms = Firm::with(
            'addresses',
            'partners'
        )->get();

        return FirmResource::collection($firms);
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

    public function store(StoreFirmRequest $request)
    {
        FirmAction::store($request->toArray());
//        return response()->json(['message' => 'Business created successfully', 'data' => new FirmResource($firm)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $applications = FirmAction::getApplicationByStatus($request->status);
        return response()->json(['data' => $applications]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Firm $firm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFirmRequest $request, Firm $firmApplication)
    {
        Log::info('Received data:', $request->toArray());
        Log::info('Firm before update:', $firmApplication->toArray());

        $firmApplication->update($request->toArray());

        Log::info('Firm after update:', $firmApplication->toArray());

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Firm $firm): \Illuminate\Http\Response
    {
        $firm->delete();
        return response()->noContent();
    }

    public function searchByReferenceNo(SearchFirmRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $applicationCode = $request->input('application_code');
        $firms = Firm::where('application_code', 'like', "%$applicationCode%")->get();

        return FirmResource::collection($firms);
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        $application = Firm::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
