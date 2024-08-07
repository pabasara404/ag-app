<?php

namespace App\Http\Controllers;

use App\Actions\IndividualBusinessAction;
use App\Http\Resources\IndividualBusinessResource;
use App\Models\IndividualBusiness;
use App\Http\Requests\StoreIndividualBusinessRequest;
use App\Http\Requests\UpdateIndividualBusinessRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndividualBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $individualBusinesses = IndividualBusiness::with(
            'addresses',
            'owner_detail',
            'other_businesses',
            'director_details',
            'gn_division'
        )->get();

        return IndividualBusinessResource::collection($individualBusinesses);
    }

    /**
     * Display a listing of the resource for the authenticated user.
     *
     * @return AnonymousResourceCollection
     */
    public function userApplications(): AnonymousResourceCollection
    {
        $userId = auth()->id();

        $applications = IndividualBusiness::with(
            'addresses',
            'owner_detail',
            'other_businesses',
            'director_details',
            'gn_division',
            'user',
        )->where('user_id', $userId)->get();

        return IndividualBusinessResource::collection($applications);
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
    public function store(StoreIndividualBusinessRequest $request)
    {
        IndividualBusinessAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $applications = IndividualBusinessAction::getApplicationByStatus($request->status);
        return response()->json(['data' => $applications]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndividualBusiness $individualBusiness)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIndividualBusinessRequest $request, IndividualBusiness $individualBusiness)
    {
        $individualBusiness->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndividualBusiness $individualBusiness)
    {
        $individualBusiness->delete();
        return response()->noContent();
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        $application = IndividualBusiness::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
