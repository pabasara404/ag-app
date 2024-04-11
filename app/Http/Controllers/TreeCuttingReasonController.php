<?php

namespace App\Http\Controllers;

use App\Models\TreeCuttingReason;
use App\Http\Requests\StoreTreeCuttingReasonRequest;
use App\Http\Requests\UpdateTreeCuttingReasonRequest;

class TreeCuttingReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(TreeCuttingReason::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTreeCuttingReasonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreeCuttingReasonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TreeCuttingReason  $treeCuttingReason
     * @return \Illuminate\Http\Response
     */
    public function show(TreeCuttingReason $treeCuttingReason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TreeCuttingReason  $treeCuttingReason
     * @return \Illuminate\Http\Response
     */
    public function edit(TreeCuttingReason $treeCuttingReason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTreeCuttingReasonRequest  $request
     * @param  \App\Models\TreeCuttingReason  $treeCuttingReason
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreeCuttingReasonRequest $request, TreeCuttingReason $treeCuttingReason)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TreeCuttingReason  $treeCuttingReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(TreeCuttingReason $treeCuttingReason)
    {
        //
    }
}
