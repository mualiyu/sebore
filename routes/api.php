<?php

use App\Models\Transaction;
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
Route::post('/sale/transaction/create', [App\Http\Controllers\ApiSaleTransactionController::class, 'create']);

Route::get('/device/get_by_id', [App\Http\Controllers\ApiDeviceController::class, 'show']);
Route::get('/device/update_code', [App\Http\Controllers\ApiDeviceController::class, 'update_code']);

Route::get('/agent/login', [App\Http\Controllers\ApiAgentController::class, 'login']);
Route::get('/agent/login_v2', [App\Http\Controllers\ApiAgentController::class, 'login_v2']);
Route::post('/agent/update_password', [App\Http\Controllers\ApiAgentController::class, 'update_password']);
Route::get('/agent/get_by_role', [App\Http\Controllers\ApiAgentController::class, 'get_agent_by_role']);

Route::get('/agent_role/get_by_org', [App\Http\Controllers\ApiAgentRoleController::class, 'get_role']);
Route::get('/agent/get_marketers_by_org', [App\Http\Controllers\ApiAgentRoleController::class, 'get_marketers_by_org']);

Route::get('/item/get_by_device', [App\Http\Controllers\ApiItemController::class, 'get_by_device']);

Route::get('/customer/get_by_agent', [App\Http\Controllers\ApiCustomerController::class, 'get_by_agent']);
Route::get('/customer/check_by_phone', [App\Http\Controllers\ApiCustomerController::class, 'check_by_phone']);
Route::post('/customer/to/agent', [App\Http\Controllers\ApiCustomerController::class, 'add_customer_to_agent']);
Route::post('/customer/create', [App\Http\Controllers\ApiCustomerController::class, 'create']);

Route::get('/get_api_by_name', [App\Http\Controllers\ApiApiController::class, 'get_by_name']);
Route::post('/new_api_user', [App\Http\Controllers\ApiApiController::class, 'create']);


Route::post('/stock/create', [App\Http\Controllers\ApiStockController::class, 'create']);
Route::post('/stock/update', [App\Http\Controllers\ApiStockController::class, 'update']);
Route::get('/stock/get_stock', [App\Http\Controllers\ApiStockController::class, 'get_stock']);

Route::get('/store/get_stores', [App\Http\Controllers\ApiStoreController::class, 'get_stores']);
Route::post('/store/add/item', [App\Http\Controllers\ApiStoreController::class, 'add_item']);
Route::post('/store/update/item', [App\Http\Controllers\ApiStoreController::class, 'update_item']);

Route::get('/sale/get_sales', [App\Http\Controllers\ApiSaleController::class, 'get_sales']);
Route::post('/sale/create_sales', [App\Http\Controllers\ApiSaleController::class, 'create_sales']);


Route::get('/test/t', function () {
    Transaction::query()->update(['type' => "collection"]);
});
