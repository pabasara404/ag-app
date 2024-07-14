<?php

namespace App\Http\Controllers;

use App\Actions\AnimalTransportationAction;
use App\Http\Resources\AnimalTransportationResource;
use App\Models\AnimalTransportation;
use App\Http\Requests\StoreAnimalTransportationRequest;
use App\Http\Requests\UpdateAnimalTransportationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnimalTransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animalTransportations = AnimalTransportation::with('animals')->get();

        return AnimalTransportationResource::collection($animalTransportations);
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
    public function store(StoreAnimalTransportationRequest $request)
    {
        AnimalTransportationAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $statuses = $request->query('statuses');
        $animalTransportations = AnimalTransportationAction::getApplicationByStatus($statuses);
        return response()->json(['data' => $animalTransportations]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnimalTransportation $animalTransportation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimalTransportationRequest $request, AnimalTransportation $animalTransportation)
    {
        $animalTransportation->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnimalTransportation $animalTransportation)
    {
        $animalTransportation->delete();
        return response()->noContent();
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        $application = AnimalTransportation::findOrFail($id);
        $application->status = $request->status;
        $application->save();

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

        $animalTransportations = AnimalTransportationAction::getApplicationByStatus($statuses);
        return response()->json(['data' => $animalTransportations]);
    }
}
