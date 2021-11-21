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

Route::get('/device/get_by_id', [App\Http\Controllers\ApiDeviceController::class, 'show']);
Route::get('/device/update_code', [App\Http\Controllers\ApiDeviceController::class, 'update_code']);

Route::get('/agent/login', [App\Http\Controllers\ApiAgentController::class, 'login']);
Route::post('/agent/update_password', [App\Http\Controllers\ApiAgentController::class, 'update_password']);

Route::get('/item/get_by_device', [App\Http\Controllers\ApiItemController::class, 'get_by_device']);

Route::get('/customer/get_by_agent', [App\Http\Controllers\ApiCustomerController::class, 'get_by_agent']);
Route::post('/customer/create', [App\Http\Controllers\ApiCustomerController::class, 'create']);

Route::get('/get_api_by_name', [App\Http\Controllers\ApiApiController::class, 'get_by_name']);
Route::post('/new_api_user', [App\Http\Controllers\ApiApiController::class, 'create']);
