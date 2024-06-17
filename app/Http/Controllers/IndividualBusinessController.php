<?php

namespace App\Http\Controllers;

use App\Actions\IndividualBusinessAction;
use App\Http\Resources\IndividualBusinessResource;
use App\Models\IndividualBusiness;
use App\Http\Requests\StoreIndividualBusinessRequest;
use App\Http\Requests\UpdateIndividualBusinessRequest;

class IndividualBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return IndividualBusinessResource::collection(IndividualBusiness::with(
            'addresses',
            'owner_detail',
            'other_businesses',
            'director_details'
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
    public function store(StoreIndividualBusinessRequest $request)
    {
        IndividualBusinessAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(IndividualBusiness $individualBusiness)
    {
        //
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
}
