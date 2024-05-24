<?php

namespace App\Http\Controllers;

use App\Http\Resources\GnOfficerResource;
use App\Models\GnOfficer;
use App\Http\Requests\StoreGnOfficerRequest;
use App\Http\Requests\UpdateGnOfficerRequest;
use Illuminate\Http\Response;

class GnOfficerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return GnOfficerResource::collection(
            GnOfficer::with("user")->get()

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
     * @param  \App\Http\Requests\StoreGnOfficerRequest  $request
     * @return Response
     */
    public function store(StoreGnOfficerRequest $request)
    {
        GnOfficer::create($request->toArray());

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     *
     * @param GnOfficer $gnOfficer
     * @return Response
     */
    public function show(GnOfficer $gnOfficer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GnOfficer $gnOfficer
     * @return Response
     */
    public function edit(GnOfficer $gnOfficer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGnOfficerRequest $request
     * @param GnOfficer $gnOfficer
     * @return Response
     */
    public function update(UpdateGnOfficerRequest $request, GnOfficer $gnOfficer)
    {
        //
        $gnOfficer->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GnOfficer $gnOfficer
     * @return Response
     */
    public function destroy(GnOfficer $gnOfficer)
    {
        $gnOfficer->delete();

        return response()->noContent();
    }
}
