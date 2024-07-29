<?php

use App\Http\Controllers\AnimalTransportationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExciseController;
use App\Http\Controllers\FirmController;
use App\Http\Controllers\GnDivisionController;
use App\Http\Controllers\GnOfficerController;
use App\Http\Controllers\IncomeCertificateController;
use App\Http\Controllers\IndividualBusinessController;
use App\Http\Controllers\MahapolaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PresidentFundController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TimberCuttingPermitApplicationController;
use App\Http\Controllers\TimberTransportingPermitApplicationController;
use App\Http\Controllers\TreeCuttingReasonController;
use App\Http\Controllers\ValuationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('role');
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (){
    Route::post('/auth/logout', [AuthController::class, 'logout']);
//    Route::get('timberCuttingPermitApplication', [TimberCuttingPermitApplicationController::class, 'index']);
});

Route::get('/applicationDetails', [ApplicationController::class, 'getApplicationDetails']);
Route::get('/applicationCountsByGNDivision', [StatisticsController::class, 'getApplicationCountsByGnDivision']);
Route::get('/applicationCountsByStatus', [StatisticsController::class, 'getApplicationCountsByStatus']);
Route::get('issuedApplicationCountsByMonthly', [StatisticsController::class, 'getIssuedApplicationCountsByMonth']);
Route::get('issuedApplicationCounts', [StatisticsController::class, 'getIssuedApplicationCounts']);
Route::get('submittedApplicationCounts', [StatisticsController::class, 'getSubmittedApplicationCounts']);

Route::post('/payment', [PaymentController::class, 'store']);
Route::get('/payment', [PaymentController::class, 'index']);
Route::delete('/payment/{id}', [PaymentController::class, 'delete']);

//routes for employees
Route::get('employee', [EmployeeController::class, 'index']);
Route::put('employee/{employee}', [EmployeeController::class, 'update']);
Route::delete('employee/{employee}', [EmployeeController::class, 'destroy']);
Route::post('employee', [EmployeeController::class, 'store']);

//routes for GNOfficer
Route::get('gnOfficer', [GnOfficerController::class, 'index']);
Route::put('gnOfficer/{gnOfficer}', [GnOfficerController::class, 'update']);
Route::delete('gnOfficer/{gnOfficer}', [GnOfficerController::class, 'destroy']);
Route::post('gnOfficer', [GnOfficerController::class, 'store']);

//routes for citizen
Route::get('citizen', [CitizenController::class, 'index']);
Route::get('citizen-by-user-id', [CitizenController::class, 'show']);
Route::put('citizen/{citizen}', [CitizenController::class, 'update']);
Route::delete('citizen/{citizen}', [CitizenController::class, 'destroy']);
Route::post('citizen', [CitizenController::class, 'store']);

//routes for individualBusiness
//Route::get('individualBusiness/searchByReferenceNo', [IndividualBusinessController::class, 'searchByReferenceNo']);
Route::get('individualBusiness', [individualBusinessController::class, 'index']);
Route::get('individualBusinessByStatus', [individualBusinessController::class, 'show']);
Route::put('individualBusiness/{individualBusiness}', [individualBusinessController::class, 'update']);
Route::delete('individualBusiness/{individualBusiness}', [individualBusinessController::class, 'destroy']);
Route::post('individualBusiness', [individualBusinessController::class, 'store']);
Route::put('individualBusiness/{id}', [individualBusinessController::class, 'updateStatus']);


// Example routes in api.php
Route::get('firmApplication/searchByReferenceNo', [FirmController::class, 'searchByReferenceNo']);
Route::get('individualBusiness/searchByReferenceNo', [IndividualBusinessController::class, 'searchByReferenceNo']);


//routes for firms
//Route::get('firmApplication/searchByReferenceNo', [FirmController::class, 'searchByReferenceNo']);
Route::get('firmApplication', [FirmController::class, 'index']);
Route::get('firmByStatus', [FirmController::class, 'show']);
Route::put('firmApplication/{firmApplication}', [FirmController::class, 'update']);
Route::delete('firmApplication/{firmApplication}', [FirmController::class, 'destroy']);
Route::post('firmApplication', [FirmController::class, 'store']);
Route::put('firmApplication/{id}', [FirmController::class, 'updateStatus']);


//routes for valuations
Route::get('valuation', [ValuationController::class, 'index']);
Route::get('valuationByStatus', [ValuationController::class, 'filterByStatus']);
Route::post('valuation', [ValuationController::class, 'store']);
Route::put('valuation/{valuation}', [ValuationController::class, 'update']);
Route::put('valuation/{id}', [ValuationController::class, 'updateStatus']);
Route::delete('valuation/{valuation}', [ValuationController::class, 'destroy']);


//routes for excises
//Route::get('exciseApplication/searchByReferenceNo', [ExciseController::class, 'searchByReferenceNo']);
Route::get('exciseApplication', [ExciseController::class, 'index']);
Route::get('exciseByStatus', [ExciseController::class, 'show']);
Route::put('exciseApplication/{exciseApplication}', [ExciseController::class, 'update']);
Route::delete('exciseApplication/{exciseApplication}', [ExciseController::class, 'destroy']);
Route::post('exciseApplication', [ExciseController::class, 'store']);
Route::put('exciseApplication/{id}', [ExciseController::class, 'updateStatus']);
Route::get('exciseByStatus', [ExciseController::class, 'filterByStatus']);

//routes for presidentFunds
//Route::get('presidentFundApplication/searchByReferenceNo', [PresidentFundController::class, 'searchByReferenceNo']);
Route::get('presidentFundApplication', [PresidentFundController::class, 'index']);
Route::get('presidentFundByStatus', [PresidentFundController::class, 'show']);
Route::put('presidentFundApplication/{presidentFundApplication}', [PresidentFundController::class, 'update']);
Route::delete('presidentFundApplication/{presidentFundApplication}', [PresidentFundController::class, 'destroy']);
Route::post('presidentFundApplication', [PresidentFundController::class, 'store']);
Route::put('presidentFundApplication/{id}', [PresidentFundController::class, 'updateStatus']);
Route::get('presidentFundByStatus', [PresidentFundController::class, 'filterByStatus']);

//routes for mahapola
//Route::get('mahapolaApplication/searchByReferenceNo', [MahapolaController::class, 'searchByReferenceNo']);
Route::get('mahapolaApplication', [MahapolaController::class, 'index']);
Route::get('mahapolaByStatus', [MahapolaController::class, 'show']);
Route::put('mahapolaApplication/{mahapolaApplication}', [MahapolaController::class, 'update']);
Route::delete('mahapolaApplication/{mahapolaApplication}', [MahapolaController::class, 'destroy']);
Route::post('mahapolaApplication', [MahapolaController::class, 'store']);
Route::put('mahapolaApplication/{id}', [MahapolaController::class, 'updateStatus']);
Route::get('mahapolaByStatus', [MahapolaController::class, 'filterByStatus']);



//routes for animalTransportations
Route::get('animalTransportation', [AnimalTransportationController::class, 'index']);
Route::get('animalTransportationByStatus', [AnimalTransportationController::class, 'filterByStatus']);
Route::post('animalTransportation', [AnimalTransportationController::class, 'store']);
Route::put('animalTransportation/{animalTransportation}', [AnimalTransportationController::class, 'update']);
Route::put('animalTransportation/{id}', [AnimalTransportationController::class, 'updateStatus']);
Route::delete('animalTransportation/{animalTransportation}', [AnimalTransportationController::class, 'destroy']);


//routes for incomeCertificates
Route::get('incomeCertificate', [IncomeCertificateController::class, 'index']);
Route::get('incomeCertificateByStatus', [IncomeCertificateController::class, 'show']);
Route::post('incomeCertificate', [IncomeCertificateController::class, 'store']);
Route::put('incomeCertificate/{incomeCertificate}', [IncomeCertificateController::class, 'update']);
Route::put('incomeCertificate/{id}', [IncomeCertificateController::class, 'updateStatus']);
Route::delete('incomeCertificate/{incomeCertificate}', [IncomeCertificateController::class, 'destroy']);

//routes for timberCuttingPermitApplications
Route::get('timberCuttingPermitApplication', [TimberCuttingPermitApplicationController::class, 'index']);
Route::get('timberCuttingPermitApplicationByStatus', [TimberCuttingPermitApplicationController::class, 'show']);
Route::put('timberCuttingPermitApplication/{timberCuttingPermitApplication}', [TimberCuttingPermitApplicationController::class, 'update']);
Route::delete('timberCuttingPermitApplication/{timberCuttingPermitApplication}', [TimberCuttingPermitApplicationController::class, 'destroy']);
Route::post('timberCuttingPermitApplication', [TimberCuttingPermitApplicationController::class, 'store']);
Route::put('timberCuttingPermitApplication/{id}', [TimberCuttingPermitApplicationController::class, 'updateStatus']);
//
//routes for timberTransportingPermitApplications
Route::get('timberTransportingPermitApplication', [TimberTransportingPermitApplicationController::class, 'index']);
Route::put('timberTransportingPermitApplication/{timberTransportingPermitApplication}', [TimberTransportingPermitApplicationController::class, 'update']);
Route::delete('timberTransportingPermitApplication/{timberTransportingPermitApplication}', [TimberTransportingPermitApplicationController::class, 'destroy']);
Route::post('timberTransportingPermitApplication', [TimberTransportingPermitApplicationController::class, 'store']);
//


//routes for gnDivisions
Route::get('gnDivision', [GnDivisionController::class, 'index']);
Route::put('gnDivision/{gnDivision}', [GnDivisionController::class, 'update']);
Route::delete('gnDivision/{gnDivision}', [GnDivisionController::class, 'destroy']);
Route::post('gnDivision', [GnDivisionController::class, 'store']);


//routes for roles
Route::get('role', [RoleController::class, 'index']);
Route::put('role/{role}', [RoleController::class, 'update']);
Route::delete('role/{role}', [RoleController::class, 'destroy']);
Route::post('role', [RoleController::class, 'store']);

//routes for treeCuttingReasons
Route::get('treeCuttingReason', [TreeCuttingReasonController::class, 'index']);
Route::put('treeCuttingReason/{treeCuttingReason}', [TreeCuttingReasonController::class, 'update']);
Route::delete('treeCuttingReason/{treeCuttingReason}', [TreeCuttingReasonController::class, 'destroy']);
Route::post('treeCuttingReason', [TreeCuttingReasonController::class, 'store']);

