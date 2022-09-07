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

    Route::group([
        'middleware' => [
            'permission:management_organizations'
            ]
        ], function () {
        
        Route::get('/management/organizations', [OrganizationController::class, 'api_organizations']);

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
