<?php

namespace App\Http\Controllers;

use App\Actions\ExciseAction;
use App\Http\Resources\ExciseResource;
use App\Models\Excise;
use App\Http\Requests\StoreExciseRequest;
use App\Http\Requests\UpdateExciseRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $excises = Excise::with('gn_division')->get();
        return ExciseResource::collection($excises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExciseRequest $request)
    {
        ExciseAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $valuation = Excise::findOrFail($id);
        return response()->json(['data' => $valuation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExciseRequest $request, $id)
    {
        $excise = Excise::findOrFail($id);
        $excise->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $excise = Excise::findOrFail($id);
        $excise->delete();
        return response()->noContent();
    }

    public function updateStatus(Request $request, $id)
    {
        $excise = Excise::findOrFail($id);
        $excise->status = $request->status;
        $excise->save();
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function filterByStatus(Request $request): JsonResponse
    {
        $statuses = $request->query('statuses', '');

        if (empty($statuses)) {
            return response()->json(['error' => 'Statuses parameter is required'], 400);
        }

        $excises = ExciseAction::getApplicationByStatus($statuses);
        return response()->json(['data' => $excises]);
    }
}
