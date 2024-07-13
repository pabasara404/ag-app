<?php

namespace App\Http\Controllers;

use App\Actions\IncomeCertificateAction;
use App\Http\Resources\IncomeCertificateResource;
use App\Http\Resources\IndividualBusinessResource;
use App\Models\IncomeCertificate;
use App\Http\Requests\StoreIncomeCertificateRequest;
use App\Http\Requests\UpdateIncomeCertificateRequest;
use App\Models\IndividualBusiness;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IncomeCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomeCertificates = IncomeCertificate::with(
            'gn_division',
            'samurdhi_details',
            'incomes')->get();

        return IncomeCertificateResource::collection($incomeCertificates);
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
    public function store(StoreIncomeCertificateRequest $request)
    {
        IncomeCertificateAction::store($request->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $applications = IncomeCertificateAction::getApplicationByStatus($request->status);
        return response()->json(['data' => $applications]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomeCertificate $incomeCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncomeCertificateRequest $request, IncomeCertificate $incomeCertificate)
    {
        $incomeCertificate->update($request->toArray());
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomeCertificate $incomeCertificate)
    {
        $incomeCertificate->delete();
        return response()->noContent();
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        $application = IncomeCertificate::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
