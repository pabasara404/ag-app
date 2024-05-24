<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimberTransportingPermitApplicationResource;
use App\Models\TimberTransportingPermitApplication;
use App\Http\Requests\StoreTimberTransportingPermitApplicationRequest;
use App\Http\Requests\UpdateTimberTransportingPermitApplicationRequest;

class TimberTransportingPermitApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TimberTransportingPermitApplicationResource::collection(TimberTransportingPermitApplication::with(
            "timber_details",
            "boundary",
            "private_land_detail"
        ));
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
    public function store(StoreTimberTransportingPermitApplicationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TimberTransportingPermitApplication $timberTransportingPermitApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimberTransportingPermitApplication $timberTransportingPermitApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimberTransportingPermitApplicationRequest $request, TimberTransportingPermitApplication $timberTransportingPermitApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimberTransportingPermitApplication $timberTransportingPermitApplication)
    {
        //
    }
}
