<?php

namespace App\Http\Controllers;

use App\Actions\TimberTransportingPermitApplicationAction;
use App\Http\Resources\TimberCuttingPermitApplicationResource;
use App\Http\Resources\TimberTransportingPermitApplicationResource;
use App\Models\TimberCuttingPermitApplication;
use App\Models\TimberTransportingPermitApplication;
use App\Http\Requests\StoreTimberTransportingPermitApplicationRequest;
use App\Http\Requests\UpdateTimberTransportingPermitApplicationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimberTransportingPermitApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = TimberTransportingPermitApplication::with(
            "timber_details",
            "boundary",
            "private_land",
            "gn_division",
            "user",
        )->get();

        return TimberTransportingPermitApplicationResource::collection($applications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimberTransportingPermitApplicationRequest $request)
    {
        TimberTransportingPermitApplicationAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $applications = TimberTransportingPermitApplicationAction::getApplicationByStatus($request->status);
        return response()->json(['data' => $applications]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimberTransportingPermitApplicationRequest $request, $id)
    {
        $timberTransportingPermitApplication = TimberTransportingPermitApplication::findOrFail($id);
        $timberTransportingPermitApplication->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $timberTransportingPermitApplication = TimberTransportingPermitApplication::findOrFail($id);
        $timberTransportingPermitApplication->delete();
        return response()->noContent();
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $application = TimberTransportingPermitApplication::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

    /**
     * Display a listing of the resource for the authenticated user.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function userApplications()
    {
        $userId = auth()->id();

        $applications = TimberTransportingPermitApplication::with(
            "timber_details",
            "boundary",
            "private_land",
            "gn_division",
            "user",
        )->where('user_id', $userId)->get();

        return TimberTransportingPermitApplicationResource::collection($applications);
    }
}
