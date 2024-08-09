<?php

namespace App\Http\Controllers;

use App\Actions\AnimalTransportationAction;
use App\Actions\ValuationAction;
use App\Http\Resources\TimberCuttingPermitApplicationResource;
use App\Http\Resources\ValuationResource;
use App\Models\TimberCuttingPermitApplication;
use App\Models\Valuation;
use App\Http\Requests\StoreValuationRequest;
use App\Http\Requests\UpdateValuationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ValuationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $valuations = Valuation::with(
            'user', 'gn_division')->get();
        return ValuationResource::collection($valuations);
    }

    /**
     * Display a listing of the resource for the authenticated user.
     *
     * @return AnonymousResourceCollection
     */
    public function userApplications()
    {
        $userId = auth()->id();

        $applications = Valuation::with(
            'user', 'gn_division'
        )->where('user_id', $userId)->get();

        return ValuationResource::collection($applications);
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
    public function store(StoreValuationRequest $request)
    {
        ValuationAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $valuation = Valuation::findOrFail($id);
        return response()->json(['data' => $valuation]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Valuation $valuation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateValuationRequest $request, Valuation $valuation)
    {
        $valuation->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Valuation $valuation)
    {
        $valuation->delete();
        return response()->noContent();
    }

    public function updateStatus(Request $request, $id)
    {
        $valuation = Valuation::findOrFail($id);
        $valuation->status = $request->status;
        $valuation->save();
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function filterByStatus(Request $request): JsonResponse
    {

        // Retrieve the statuses query parameter
        $statuses = $request->query('statuses', '');

        // Ensure that the statuses parameter is not null or empty
        if (empty($statuses)) {
            return response()->json(['error' => 'Statuses parameter is required'], 400);
        }

        $valuations = ValuationAction::getApplicationByStatus($statuses);
        return response()->json(['data' => $valuations]);
    }
}
