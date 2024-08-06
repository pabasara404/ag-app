<?php

namespace App\Http\Controllers;

use App\Models\AnimalTransportation;
use App\Models\Excise;
use App\Models\Firm;
use App\Models\IndividualBusiness;
use App\Models\Mahapola;
use App\Models\PresidentFund;
use App\Models\TimberCuttingPermitApplication;
use App\Models\TimberTransportingPermitApplication;
use App\Models\Valuation;
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

        // Determine the model class based on the table name
        $modelClass = null;
        switch ($tableName) {
            case 'timber_cutting_permit_applications':
                $modelClass = TimberCuttingPermitApplication::class;
                break;
            case 'timber_transporting_applications':
                $modelClass = TimberTransportingPermitApplication::class;
                break;
                case 'individual_businesses':
                $modelClass = IndividualBusiness::class;
                break;
                case 'firms':
                $modelClass = Firm::class;
                break;
                case 'animal_transportations':
                $modelClass = AnimalTransportation::class;
                break;
                case 'president_funds':
                $modelClass = PresidentFund::class;
                break;
                case 'mahapolas':
                $modelClass = Mahapola::class;
                break;
                case 'excises':
                $modelClass = Excise::class;
                break;
                case 'valuations':
                $modelClass = Valuation::class;
                break;
        }

        if (!$modelClass) {
            return response()->json(['error' => 'Invalid table name'], 400);
        }

        // Retrieve application details from the specified table
        $applicationDetails = $modelClass::where('application_code', $applicationCode)
            ->where('status', 'Awaiting Payment')
            ->with($this->getRelationships($modelClass)) // Eager load relationships
            ->first();

        if (!$applicationDetails) {
            return response()->json(['error' => 'Application not found or not approved yet'], 404);
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

    private function getRelationships($modelClass)
    {
        $relationships = [];

        switch ($modelClass) {
            case TimberCuttingPermitApplication::class:
                $relationships = [
                    'gn_division',
                    'tree_details',
                    'deed_detail',
                    'land_detail',
                    'boundary',
                    'tree_cutting_reasons',
                    'user'
                ];
                break;
            case TimberTransportingPermitApplication::class:
                $relationships = [
                    'gn_division',
                    'timber_details',
                    'boundary',
                    'private_land'
                ];
                break;
            case IndividualBusiness::class:
                $relationships = [
                    'addresses',
                    'owner_detail',
                    'other_businesses',
                    'director_details',
                    'gn_division'
                ];
                break;
            case Firm::class:
                $relationships = [
                    'addresses',
                    'partners',
                    'gn_division'
                ];
                break;
            case AnimalTransportation::class:
                $relationships = [
                    'animals'
                ];
                break;
            case PresidentFund::class:
                $relationships = [
                    'gn_division'
                ];
                break;
            case Mahapola::class:
                $relationships = [
                    'gn_division'
                ];
                break;
            case Excise::class:
                $relationships = [
                    'gn_division',
                ];
                break;
            case Valuation::class:
                $relationships = [
                    'gn_division',
                    'private_land'
                ];
                break;
        }

        return $relationships;
    }
}
