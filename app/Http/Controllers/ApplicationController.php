<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function getApplicationDetails(Request $request)
    {
        $tableName = $request->input('table_name');
        $applicationCode = $request->input('application_code');

        if (empty($tableName) || empty($applicationCode)) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        // Retrieve application details from the specified table
        $applicationDetails = DB::table($tableName)
            ->where('application_code', $applicationCode)
            ->where('status', 'issued')
            ->first();

        if (!$applicationDetails) {
            return response()->json(['error' => 'Application not found or not issued'], 404);
        }

        // Check for an existing payment record
        $existingPayment = DB::table('payments')
            ->where('application_code', $applicationCode)
            ->first();

        if ($existingPayment) {
            return response()->json(['error' => 'Payment already exists for this application'], 400);
        }

        return response()->json($applicationDetails);
    }
}
