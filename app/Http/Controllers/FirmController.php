<?php

namespace App\Http\Controllers;

use App\Actions\FirmAction;
use App\Http\Resources\FirmResource;
use App\Models\Firm;
use App\Http\Requests\StoreFirmRequest;
use App\Http\Requests\UpdateFirmRequest;
use App\Http\Requests\SearchFirmRequest;
use App\Models\OtherPartneredBusiness;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $firm = FirmAction::store($request->toArray());
//        return response()->json(['message' => 'Business created successfully', 'data' => new FirmResource($firm)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Firm $firm)
    {
        //
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
    public function update(UpdateFirmRequest $request, Firm $firm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Firm $firm)
    {
        //
    }

    public function searchByReferenceNo(SearchFirmRequest $request)
    {
        $applicationCode = $request->input('application_code');
        $firms = Firm::where('application_code', 'like', "%$applicationCode%")->get();

        return FirmResource::collection($firms);
    }
}
