<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Turnicet;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadryController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\BackApiController;
use App\Http\Controllers\VacationIntegrationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'auth:api'
], function ($router) {
    
    Route::get('/1c/vacations', [VacationIntegrationController::class, 'vacations_1c_api']);
    Route::post('/1c/vacations/{vacation_id}/accept', [VacationIntegrationController::class, 'vacations_1c_api_success']);
    Route::post('/1c/vacations/{vacation_id}/refuse', [VacationIntegrationController::class, 'vacations_1c_api_refuse']);

    Route::get('/profile', [AuthController::class, 'userProfile']);
    
    Route::get('/cadry/ExportToWord/{id}', [OrganizationController::class, 'word_export_api']);

    Route::get('/filter/railways', [OrganizationController::class, 'filter_api_railways']);
    Route::get('/filter/organizations', [OrganizationController::class, 'filter_api_organizations']);
    Route::get('/filter/staffs', [OrganizationController::class, 'filter_api_staffs']);
    Route::get('/filter/departments', [OrganizationController::class, 'filter_api_departments']);
    Route::get('/filter/regions', [OrganizationController::class, 'filter_api_regions']);
    Route::get('/filter/cities', [OrganizationController::class, 'filter_api_cities']);
    Route::get('/filter/educations', [OrganizationController::class, 'filter_api_educations']);
    Route::get('/filter/vacations', [OrganizationController::class, 'filter_api_vacations']);
    Route::get('/filter/worklevels', [OrganizationController::class, 'filter_api_worklevels']);
    Route::get('/filter/academicTitlies', [OrganizationController::class, 'filter_api_academicTitlies']);
    Route::get('/filter/academicDegree', [OrganizationController::class, 'filter_api_academicDegree']);
    Route::get('/filter/nationalities', [OrganizationController::class, 'filter_api_nationalities']);
    Route::get('/filter/parties', [OrganizationController::class, 'filter_api_parties']);
    Route::get('/filter/languages', [OrganizationController::class, 'filter_api_languages']);
    Route::get('/filter/instituts', [OrganizationController::class, 'filter_api_instituts']);
    Route::get('/filter/abroads', [OrganizationController::class, 'filter_api_abroads']);
    Route::get('/filter/academics', [OrganizationController::class, 'filter_api_academics']);

    
    Route::get('/organization/filter/departments', [OrganizationController::class, 'filter_api_org_departments']);
    Route::get('/organization/filter/staffs', [OrganizationController::class, 'filter_api_org_staffs`']);

    Route::group([
        'middleware' => [
            'permission:management_organizations'
            ]
        ], function () {
        
        Route::get('/management/organizations', [OrganizationController::class, 'api_organizations']);

    }); 

    Route::group([
        'middleware' => [
            'permission:management_statistics'
            ]
        ], function () {
        
        Route::get('/management/statistics', [CadryController::class, 'api_statistics']);
        
    }); 

    Route::group([
        'middleware' => [
            'permission:organization_cadries'
            ]
        ], function () {

        Route::get('/organization/cadries', [OrganizationController::class, 'api_cadries']);
        Route::get('/organization/cadries/{id}', [BackApiController::class, 'api_cadry_edit']);
        Route::post('/organization/cadries/{cadry}', [BackApiController::class, 'api_cadry_edit_post']);
        Route::post('/organization/cadries/{cadry}/update/photo', [BackApiController::class, 'api_cadry_update_photo_post']);

        
        Route::get('/organization/cadries/information/{cadry}', [BackApiController::class, 'api_cadry_information']);
        Route::post('/organization/cadries/information/{cadry}', [BackApiController::class, 'api_cadry_information_post']);

        
        Route::get('/organization/cadry/instituts', [BackApiController::class, 'api_cadry_institut']);

        Route::get('/organization/cadry/abroadStudies', [OrganizationController::class, 'cadry_api_abroadStudies']);
        Route::get('/organization/cadry/academicStudies', [OrganizationController::class, 'cadry_api_academicStudies']);
       
    }); 

    Route::group([
        'middleware' => [
            'permission:administration:administration_permissions'
            ]
        ], function () {
        
        Route::get('/administration/permissions', [OrganizationController::class, 'api_permissions']);
       
    });
    
});


Route::post('control', function (Request $request) {

    $control = new Turnicet();
    $control->railway_id = 1;
    $control->organization_id = 1;
    $control->department_id = 1;
    $control->organization_name = $request->organization_name;
    $control->department_name = $request->action;
    $control->tabel = $request->tabel;
    $control->fullname = $request->fullname;
    $control->save();

    return response()->json(['message' => 'success'], 200);
});
