<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Turnicet;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
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

Route::post('test', function (Request $request) {

    $responce = app('App\Http\Controllers\ChatController')->sms($request->phone, $request->text);

    return response($responce);
});