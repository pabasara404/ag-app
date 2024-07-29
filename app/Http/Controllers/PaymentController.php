<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'payment_type' => 'required|string',
            'application_code' => 'required|string',
            'amount' => 'required|numeric',
            'receipt_no' => 'required|string',
            'paid_date' => 'required|date',
            'contact_number' => 'required|string|max:20',
            'nic' => 'required|string|max:12',
        ]);

        // Find the application with status 'issued'
        $applicationTable = $request->payment_type;
        $applicationCode = $request->application_code;

        $application = DB::table($applicationTable)
            ->where('application_code', $applicationCode)
            ->where('status', 'issued')
            ->first();

        if (!$application) {
            return response()->json(['message' => 'Application not found or not issued'], 404);
        }

        // Create the payment
        $payment = Payment::create([
            'name' => $validated['name'],
            'payment_type' => $validated['payment_type'],
            'application_code' => $validated['application_code'],
            'amount' => $validated['amount'],
            'receipt_no' => $validated['receipt_no'],
            'paid_date' => $validated['paid_date'],
            'contact_number' => $validated['contact_number'],
            'nic' => $validated['nic'],
            'application_id' => $application->id,
            'application_table' => $applicationTable
        ]);

        return response()->json($payment, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'payment_type' => 'required|string',
            'application_code' => 'required|string',
            'amount' => 'required|numeric',
            'receipt_no' => 'required|string',
            'paid_date' => 'required|date',
            'contact_number' => 'required|string|max:20',
            'nic' => 'required|string|max:12',
        ]);

        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Find the application
        $applicationTable = $request->payment_type;
        $applicationCode = $request->application_code;

        $application = DB::table($applicationTable)->where('application_code', $applicationCode)->first();

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        // Update the payment
        $payment->update([
            'name' => $validated['name'],
            'payment_type' => $validated['payment_type'],
            'application_code' => $validated['application_code'],
            'amount' => $validated['amount'],
            'receipt_no' => $validated['receipt_no'],
            'paid_date' => $validated['paid_date'],
            'contact_number' => $validated['contact_number'],
            'nic' => $validated['nic'],
            'application_id' => $application->id,
            'application_table' => $applicationTable
        ]);

        return response()->json($payment, 200);
    }

    public function delete($id)
    {
        try {
            $payment = Payment::find($id);
            if (!$payment) {
                return response()->json(['message' => 'Payment not found'], 404);
            }
            $payment->delete();
            return response()->json(['message' => 'Payment deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting payment'], 500);
        }
    }
}
