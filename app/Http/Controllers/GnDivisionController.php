<?php

namespace App\Http\Controllers;

use App\Http\Resources\GnDivisionResource;
use App\Models\GnDivision;
use App\Http\Requests\StoreGnDivisionRequest;
use App\Http\Requests\UpdateGnDivisionRequest;
use Illuminate\Http\Response;

class GnDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return GnDivisionResource::collection(
            GnDivision::with('gn_officer')->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGnDivisionRequest  $request
     * @return Response
     */
    public function store(StoreGnDivisionRequest $request)
    {
        $gnDivisionData = $request->all();
        $gnDivisionData['gn_officer_id'] = $request->input('gn_officer.id');

        GnDivision::create($gnDivisionData);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GnDivision  $gnDivision
     * @return Response
     */
    public function show(GnDivision $gnDivision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GnDivision  $gnDivision
     * @return Response
     */
    public function edit(GnDivision $gnDivision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGnDivisionRequest  $request
     * @param  \App\Models\GnDivision  $gnDivision
     * @return Response
     */
    public function update(UpdateGnDivisionRequest $request, GnDivision $gnDivision): Response
    {
        $gnDivisionData = $request->all();
        $gnDivisionData['gn_officer_id'] = $request->input('gn_officer.id');

        $gnDivision->update($gnDivisionData);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GnDivision  $gnDivision
     * @return Response
     */
    public function destroy(GnDivision $gnDivision)
    {
        $gnDivision->delete();

        return response()->noContent();
    }
}
