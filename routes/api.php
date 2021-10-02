<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/transaction/create', [App\Http\Controllers\ApiTransactionController::class, 'create']);

Route::get('/device/get_by_code', [App\Http\Controllers\ApiDeviceController::class, 'show']);
Route::post('/device/update_code', [App\Http\Controllers\ApiDeviceController::class, 'update_code']);

Route::get('/agent/get_by_phone', [App\Http\Controllers\ApiAgentController::class, 'get_by_phone']);
Route::post('/agent/update_password', [App\Http\Controllers\ApiAgentController::class, 'update_password']);

Route::get('/item/get_by_device', [App\Http\Controllers\ApiItemController::class, 'get_by_device']);

Route::get('/get_api_by_name', [App\Http\Controllers\ApiApiController::class, 'get_by_name']);
Route::post('/new_api_user', [App\Http\Controllers\ApiApiController::class, 'create']);
