<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'show_profile'])->name('profile');
Route::get('/user/{id}/profile', [App\Http\Controllers\HomeController::class, 'show_single_user'])->name('show_single_user');
Route::post('/update_user', [App\Http\Controllers\HomeController::class, 'update_user'])->name('update_user');
Route::post('/update_single_user/{id}', [App\Http\Controllers\HomeController::class, 'update_single_user'])->name('update_single_user');
Route::post('/update_organization/{id}', [App\Http\Controllers\HomeController::class, 'update_organization'])->name('update_organization');
Route::post('/update_org_pic/{id}', [App\Http\Controllers\HomeController::class, 'update_org_pic'])->name('update_org_pic');
Route::post('/user/{id}/delete', [App\Http\Controllers\HomeController::class, 'delete_user'])->name('delete_user');

//Users
Route::get('/users', [App\Http\Controllers\HomeController::class, 'show_users'])->name('show_users');
Route::get('/create_user', [App\Http\Controllers\HomeController::class, 'show_add_user'])->name('show_add_user');
Route::post('/create_user', [App\Http\Controllers\HomeController::class, 'create_user'])->name('create_user');
Route::post('/create_user', [App\Http\Controllers\HomeController::class, 'create_user'])->name('create_user');
Route::post('/change_user_role/{id}', [App\Http\Controllers\HomeController::class, 'change_user_role'])->name('change_user_role');

//Agents
Route::get('/agents', [App\Http\Controllers\AgentController::class, 'show_agents'])->name('show_agents');
Route::get('/agent/{id}', [App\Http\Controllers\AgentController::class, 'show_single_agent'])->name('show_single_agent');
Route::get('/create_agent', [App\Http\Controllers\AgentController::class, 'show_add_agent'])->name('show_add_agent');
Route::post('/create_agent', [App\Http\Controllers\AgentController::class, 'create_agent'])->name('create_agent');
Route::post('/update_agent/{id}', [App\Http\Controllers\AgentController::class, 'update_agent'])->name('update_agent');


//devices
Route::get('/devices', [App\Http\Controllers\DeviceController::class, 'show_devices'])->name('show_devices');
Route::get('/device/{id}', [App\Http\Controllers\DeviceController::class, 'show_single_device'])->name('show_single_device');
Route::get('/create_device', [App\Http\Controllers\DeviceController::class, 'show_add_device'])->name('show_add_device');
Route::post('/create_device', [App\Http\Controllers\DeviceController::class, 'create_device'])->name('create_device');
Route::post('/update_device/{id}', [App\Http\Controllers\DeviceController::class, 'update_device'])->name('update_device');


//items
Route::get('/items', [App\Http\Controllers\ItemController::class, 'show_all_items'])->name('show_all_items');
Route::get('/device/{id}/items', [App\Http\Controllers\ItemController::class, 'show_items'])->name('show_items');
Route::get('/create_item/{id}', [App\Http\Controllers\ItemController::class, 'show_add_item'])->name('show_add_item');
Route::get('/create_item', [App\Http\Controllers\ItemController::class, 'show_add_direct_item'])->name('show_add_direct_item');
Route::get('/device/{d_id}/item/{i_id}/edit', [App\Http\Controllers\ItemController::class, 'show_edit_item'])->name('show_edit_item');
Route::post('/create_item', [App\Http\Controllers\ItemController::class, 'create_item'])->name('create_item');
Route::post('/update_item/{id}', [App\Http\Controllers\ItemController::class, 'update_item'])->name('update_item');
Route::post('/delete_item/{id}', [App\Http\Controllers\ItemController::class, 'delete_item'])->name('delete_item');
Route::post('/create_category', [App\Http\Controllers\ItemController::class, 'create_category'])->name('create_category');

//customers
Route::get('/agent/{id}/customers', [App\Http\Controllers\CustomerController::class, 'show_customers'])->name('show_customers');
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'show_all_customers'])->name('show_all_customers');
Route::get('/create_customer/{id}', [App\Http\Controllers\CustomerController::class, 'show_add_customer'])->name('show_add_customer');
Route::get('/create_customer', [App\Http\Controllers\CustomerController::class, 'show_add_direct_customer'])->name('show_add_direct_customer');
Route::get('/customer/{a_id}/edit/{c_id}', [App\Http\Controllers\CustomerController::class, 'show_edit_customer'])->name('show_edit_customer');
Route::post('/create_customer', [App\Http\Controllers\CustomerController::class, 'create_customer'])->name('create_customer');
Route::post('/update_customer/{id}', [App\Http\Controllers\CustomerController::class, 'update_customer'])->name('update_customer');
Route::post('/delete_customer/{id}', [App\Http\Controllers\CustomerController::class, 'delete_customer'])->name('delete_customer');


//Payments route 
Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'index'])->name('show_payment');
Route::post('/payment', [App\Http\Controllers\PaymentController::class, 'get_t_list'])->name('generate_pay');
Route::post('/pay/single/transaction', [App\Http\Controllers\PaymentController::class, 'pay_single_t'])->name('pay_single_t');
Route::post('/pay/all/transaction', [App\Http\Controllers\PaymentController::class, 'pay_all_tran_p_c'])->name('pay_all_tran_p_c');
Route::get('/customer_name_search_p', [App\Http\Controllers\PaymentController::class, 'customer_search'])->name('customer_p');

//api test route 
Route::get('/test/api', [App\Http\Controllers\testController::class, 'index'])->name('index');
Route::get('/test/apii', [App\Http\Controllers\testController::class, 'insert']);
