<?php

namespace App\Http\Controllers;

use App\Actions\PresidentFundAction;
use App\Http\Resources\PresidentFundResource;
use App\Models\PresidentFund;
use App\Http\Requests\StorePresidentFundRequest;
use App\Http\Requests\UpdatePresidentFundRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PresidentFundController extends Controller
{
    public function index()
    {
        $presidentFunds = PresidentFund::with('gn_division', 'user')->get();
        return PresidentFundResource::collection($presidentFunds);
    }


    /**
     * Display a listing of the resource for the authenticated user.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function userApplications()
    {
        $userId = auth()->id();

        $applications = PresidentFund::with(
            "gn_division",
            "user"
        )->where('user_id', $userId)->get();

        return PresidentFundResource::collection($applications);
    }

    public function store(StorePresidentFundRequest $request)
    {
        PresidentFundAction::store($request->toArray());
    }

    public function show(Request $request, $id)
    {
        $presidentFund = PresidentFund::findOrFail($id);
        return response()->json(['data' => $presidentFund]);
    }

    public function update(UpdatePresidentFundRequest $request, $id)
    {
        $presidentFund = PresidentFund::findOrFail($id);
        $presidentFund->update($request->toArray());
        return response()->noContent();
    }

    public function destroy($id)
    {
        $presidentFund = PresidentFund::findOrFail($id);
        $presidentFund->delete();
        return response()->noContent();
    }

    public function updateStatus(Request $request, $id)
    {
        $presidentFund = PresidentFund::findOrFail($id);
        $presidentFund->status = $request->status;
        $presidentFund->save();
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function filterByStatus(Request $request): JsonResponse
    {
        $statuses = $request->query('statuses', '');

        if (empty($statuses)) {
        return response()->json(['error' => 'Statuses parameter is required'], 400);
        }

        $presidentFunds = PresidentFundAction::getApplicationByStatus($statuses);
        return response()->json(['data' => $presidentFunds]);
    }
}
