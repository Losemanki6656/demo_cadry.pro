<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Turnicet;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadryController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\BackApiController;
use App\Http\Controllers\StaffController;
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
    
    Route::get('/filter/cadry-informations', [OrganizationController::class, 'filter_api_cadry_informations']);

    
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

        //organization-cadries    
            Route::get('/organization/cadries', [OrganizationController::class, 'api_cadries']);
            Route::get('/organization/cadries/{id}', [BackApiController::class, 'api_cadry_edit']);
            Route::put('/organization/cadries/{cadry}', [BackApiController::class, 'api_cadry_edit_post']);
            Route::post('/organization/cadries/{cadry}/update/photo', [BackApiController::class, 'api_cadry_update_photo_post']);

            
            Route::get('/organization/cadries/information/{cadry}', [BackApiController::class, 'api_cadry_information']);
            Route::put('/organization/cadries/information/{cadry}', [BackApiController::class, 'api_cadry_information_post']);

            
            Route::get('/organization/cadry/instituts', [BackApiController::class, 'api_cadry_institut']);
            Route::post('/organization/cadry/instituts/{cadry_id}/add', [BackApiController::class, 'api_cadry_institut_add']);
            Route::put('/organization/cadry/instituts/{infoeducation_id}/update', [BackApiController::class, 'api_cadry_institut_update']);
            Route::delete('/organization/cadry/instituts/{infoeducation_id}/delete', [BackApiController::class, 'api_cadry_institut_delete']);

            Route::get('/organization/cadry/{cadry_id}/abroadStudies', [BackApiController::class, 'cadry_api_abroadStudies']);
            Route::post('/organization/cadry/abroadStudies/{cadry_id}/add', [BackApiController::class, 'cadry_api_abroadStudies_add']);
            Route::put('/organization/cadry/abroadStudies/{abroad_study_id}/update', [BackApiController::class, 'cadry_api_abroadStudies_update']);
            Route::delete('/organization/cadry/abroadStudies/{abroad_study_id}/delete', [BackApiController::class, 'cadry_api_abroadStudies_delete']);

            Route::get('/organization/cadry/{cadry_id}/academicStudies', [BackApiController::class, 'cadry_api_academicStudies']);
            Route::post('/organization/cadry/academicStudies/{cadry_id}/add', [BackApiController::class, 'cadry_api_academicStudies_add']);
            Route::put('/organization/cadry/academicStudies/{academic_study_id}/update', [BackApiController::class, 'cadry_api_academicStudies_update']);
            Route::delete('/organization/cadry/academicStudies/{academic_study_id}/delete', [BackApiController::class, 'cadry_api_academicStudies_delete']);

            
            Route::get('/organization/cadry/{id}/careers', [BackApiController::class, 'cadry_api_careers']);
            Route::post('/organization/cadry/career/{cadry_id}/add', [BackApiController::class, 'cadry_api_career_add']);
            Route::put('/organization/cadry/career/{career_id}/update', [BackApiController::class, 'cadry_api_career_update']);
            Route::delete('/organization/cadry/career/{career_id}/delete', [BackApiController::class, 'cadry_api_career_delete']);
            Route::put('/organization/cadry/career/sortable', [BackApiController::class, 'api_career_sortable']);
        
            Route::get('/organization/cadry/{cadry_id}/relatives', [BackApiController::class, 'cadry_api_relatives']);
            Route::post('/organization/cadry/relatives/{cadry_id}/add', [BackApiController::class, 'api_add_relative_cadry']);
            Route::put('/organization/cadry/relatives/{cadry_relative_id}/update', [BackApiController::class, 'api_update_relative_cadry']);
            Route::delete('/organization/cadry/relatives/{cadry_relative_id}/delete', [BackApiController::class, 'api_delete_relative_cadry']);
            Route::put('/organization/cadry/relatives/sortable', [BackApiController::class, 'api_relatives_sortable']);

            
            Route::get('/organization/cadry/{cadry_id}/punishments', [BackApiController::class, 'cadry_api_punishments']);
            Route::post('/organization/cadry/punishment/{cadry_id}/add', [BackApiController::class, 'api_add_discip_cadry']);
            Route::put('/organization/cadry/punishment/{punishment_id}/update', [BackApiController::class, 'api_update_discip_cadry']);
            Route::delete('/organization/cadry/punishment/{punishment_id}/delete', [BackApiController::class, 'api_delete_discip_cadry']);

            
            Route::get('/organization/cadry/{cadry_id}/incentives', [BackApiController::class, 'api_cadry_incentives']);
            Route::post('/organization/cadry/incentives/{cadry_id}/add', [BackApiController::class, 'api_add_incentive_cadry']);
            Route::put('/organization/cadry/incentives/{incentive_id}/update', [BackApiController::class, 'api_update_incentive_cadry']);
            Route::delete('/organization/cadry/incentives/{incentive_id}/delete', [BackApiController::class, 'api_delete_incentive_cadry']);

            Route::get('/organization/cadry/{cadry_id}/stafffiles', [BackApiController::class, 'api_cadry_stafffiles']);
            Route::post('/organization/cadry/stafffiles/{cadry_id}/add', [BackApiController::class, 'api_add_stafffiles_cadry']);
            Route::post('/organization/cadry/stafffiles/{staff_file_id}/update', [BackApiController::class, 'api_update_stafffiles_cadry']);
            Route::delete('/organization/cadry/stafffiles/{staff_file_id}/delete', [BackApiController::class, 'api_delete_stafffiles_cadry']);

            
            Route::get('/organization/cadry/{cadry_id}/meds', [BackApiController::class, 'api_cadry_meds']);
            Route::delete('/organization/cadry/meds/{med_id}/delete', [BackApiController::class, 'api_cadry_meds_delete']);

            
        Route::get('/organization/cadries/info', [OrganizationController::class, 'cadries_info']);
   
        //organization-Staff-positions
       // Route::get('/organization/staff/positions', [StaffController::class, 'api_staff_positions']);
    });

    Route::group([
        'middleware' => [
            'permission:organization_cadries'
            ]
        ], function () {

        //organization-Staff-positions
        Route::get('/organization/staff/positions', [StaffController::class, 'api_staff_positions']);
        Route::get('/organization/staff/categories', [StaffController::class, 'api_categories']);

        Route::post('/organization/staff/add', [StaffController::class, 'api_add_staff']);
        Route::put('/organization/staff/{staff_id}/update', [StaffController::class, 'api_update_staff']);
        Route::delete('/organization/staff/{staff_id}/delete', [StaffController::class, 'api_delete_staff']);
        
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
