<?php

namespace App\Http\Controllers;

use App\Actions\TimberCuttingPermitApplicationAction;
use App\Http\Requests\StoreTimberCuttingPermitApplicationRequest;
use App\Http\Requests\UpdateTimberCuttingPermitApplicationRequest;
use App\Http\Resources\TimberCuttingPermitApplicationResource;
use App\Models\TimberCuttingPermitApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimberCuttingPermitApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return TimberCuttingPermitApplicationResource::collection(
            TimberCuttingPermitApplication::with(
                "gn_division",
                "tree_details",
                "deed_detail",
                "land_detail",
                "boundary",
                "user",
                "tree_cutting_reasons"
            )->get()
        );
    }

    /**
     * Display a listing of the resource for the authenticated user.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function userApplications()
    {
        $userId = auth()->id();

        $applications = TimberCuttingPermitApplication::with(
            "gn_division",
            "tree_details",
            "deed_detail",
            "land_detail",
            "boundary",
            "user",
            "tree_cutting_reasons"
        )->where('user_id', $userId)->get();

        return TimberCuttingPermitApplicationResource::collection($applications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTimberCuttingPermitApplicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreTimberCuttingPermitApplicationRequest $request
    )
    {

        TimberCuttingPermitApplicationAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimberCuttingPermitApplication  $timberCuttingPermitApplication
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $applications = TimberCuttingPermitApplicationAction::getApplicationByStatus($request->status);
        return response()->json(['data' => $applications]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimberCuttingPermitApplication  $timberCuttingPermitApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(TimberCuttingPermitApplication $timberCuttingPermitApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTimberCuttingPermitApplicationRequest  $request
     * @param  \App\Models\TimberCuttingPermitApplication  $timberCuttingPermitApplication
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTimberCuttingPermitApplicationRequest $request, TimberCuttingPermitApplication $timberCuttingPermitApplication)
    {
        $timberCuttingPermitApplication->update($request->toArray());
        return response('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimberCuttingPermitApplication  $timberCuttingPermitApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimberCuttingPermitApplication $timberCuttingPermitApplication)
    {
        $timberCuttingPermitApplication->delete();
        return response('', 204);
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        $application = TimberCuttingPermitApplication::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
