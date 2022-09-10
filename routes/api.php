<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Turnicet;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadryController;
use App\Http\Controllers\OrganizationController;

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
    
    Route::get('/profile', [AuthController::class, 'userProfile']);
    
    Route::get('/cadry/ExportToWord/{id}', [OrganizationController::class, 'word_export_api']);

    Route::get('/filter/railways', [OrganizationController::class, 'filter_api_railways']);
    Route::get('/filter/organizations', [OrganizationController::class, 'filter_api_organizations']);
    Route::get('/filter/staffs', [OrganizationController::class, 'filter_api_staffs']);
    Route::get('/filter/departments', [OrganizationController::class, 'filter_api_departments']);
    Route::get('/filter/regions', [OrganizationController::class, 'filter_api_regions']);
    Route::get('/filter/educations', [OrganizationController::class, 'filter_api_educations']);
    Route::get('/filter/vacations', [OrganizationController::class, 'filter_api_vacations']);

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
