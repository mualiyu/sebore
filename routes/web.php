<?php

use App\Models\Transaction;
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
    return redirect('/home');
});


// 
// **** MAIN ADMIN ROUTES (START) ****
// 

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
Route::get('/agents/{id}', [App\Http\Controllers\AgentController::class, 'show_single_agent'])->name('show_single_agent');
Route::get('/create_agent', [App\Http\Controllers\AgentController::class, 'show_add_agent'])->name('show_add_agent');
Route::post('/create_agent', [App\Http\Controllers\AgentController::class, 'create_agent'])->name('create_agent');
Route::post('/update_agent/{id}', [App\Http\Controllers\AgentController::class, 'update_agent'])->name('update_agent');


// Agents role
Route::get('/role/agent', [App\Http\Controllers\AgentRoleController::class, 'index'])->name('show_all_agent_roles');
Route::get('/role/agent/create', [App\Http\Controllers\AgentRoleController::class, 'create'])->name('show_add_agent_role');
Route::post('/role/agent/create', [App\Http\Controllers\AgentRoleController::class, 'store'])->name('store_agent_role');
Route::post('/role/agent/{id}/delete', [App\Http\Controllers\ItemController::class, 'destroy'])->name('delete_agent_role');


//devices
Route::get('/devices', [App\Http\Controllers\DeviceController::class, 'show_devices'])->name('show_devices');
Route::get('/device/{id}', [App\Http\Controllers\DeviceController::class, 'show_single_device'])->name('show_single_device');
Route::get('/create_device', [App\Http\Controllers\DeviceController::class, 'show_add_device'])->name('show_add_device');
Route::post('/create_device', [App\Http\Controllers\DeviceController::class, 'create_device'])->name('create_device');
Route::post('/update_device/{id}', [App\Http\Controllers\DeviceController::class, 'update_device'])->name('update_device');
Route::post('/reset_device/{id}', [App\Http\Controllers\DeviceController::class, 'reset_device'])->name('reset_device');


//items
Route::get('/device/{id}/items', [App\Http\Controllers\ItemController::class, 'show_items'])->name('show_items');
Route::get('/create/item/{id}', [App\Http\Controllers\ItemController::class, 'show_add_item'])->name('show_add_item');
Route::get('/create/item', [App\Http\Controllers\ItemController::class, 'show_add_direct_item'])->name('show_add_direct_item');
// Route::get('/device/{d_id}/item/{i_id}/edit', [App\Http\Controllers\ItemController::class, 'show_edit_item'])->name('show_edit_item');
Route::post('/create/item', [App\Http\Controllers\ItemController::class, 'create_item'])->name('create_item');
// Route::post('/update/item/{id}', [App\Http\Controllers\ItemController::class, 'update_item'])->name('update_item');
Route::post('/delete/item/{id}', [App\Http\Controllers\ItemController::class, 'delete_item'])->name('delete_item');
Route::post('/create_category', [App\Http\Controllers\ItemController::class, 'create_category'])->name('create_category');

// items cart
Route::get('/items', [App\Http\Controllers\ItemsCartController::class, 'show_all_items'])->name('show_all_items');
// Route::get('/items/{id}', [App\Http\Controllers\ItemsCartController::class, 'show_item_cart'])->name('show_items_cart');
// Route::get('/create_item/{id}', [App\Http\Controllers\ItemController::class, 'show_add_item'])->name('show_add_item_cart');
Route::get('/create_item', [App\Http\Controllers\ItemsCartController::class, 'show_add_item'])->name('show_add_direct_item_cart');
Route::get('items/{id}/edit', [App\Http\Controllers\ItemsCartController::class, 'show_edit_item'])->name('show_edit_item_cart');
Route::post('/create_item', [App\Http\Controllers\ItemsCartController::class, 'create_item'])->name('create_item_cart');
Route::post('/update_item/{id}', [App\Http\Controllers\ItemsCartController::class, 'update_item'])->name('update_item_cart');
Route::post('/delete_item/{id}', [App\Http\Controllers\ItemsCartController::class, 'delete_item'])->name('delete_item_cart');
// Route::post('/create_category', [App\Http\Controllers\ItemController::class, 'create_category'])->name('create_category');

//customers
Route::get('/agents/{id}/customers', [App\Http\Controllers\CustomerController::class, 'show_customers'])->name('show_customers');
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'show_all_customers'])->name('show_all_customers');
Route::get('/create_customer/{id}', [App\Http\Controllers\CustomerController::class, 'show_add_customer'])->name('show_add_customer');
Route::get('/create_customer', [App\Http\Controllers\CustomerController::class, 'show_add_direct_customer'])->name('show_add_direct_customer');
Route::get('/customer/edit/{c_id}', [App\Http\Controllers\CustomerController::class, 'show_edit_customer'])->name('show_edit_customer');
Route::post('/create_customer', [App\Http\Controllers\CustomerController::class, 'create_customer'])->name('create_customer');
Route::post('/update_customer/{id}', [App\Http\Controllers\CustomerController::class, 'update_customer'])->name('update_customer');
Route::post('/add_customer_to_agent', [App\Http\Controllers\CustomerController::class, 'add_customer_to_agent'])->name('add_customer_to_agent');
Route::post('/delete_customer/{id}', [App\Http\Controllers\CustomerController::class, 'delete_customer'])->name('delete_customer');
Route::post('/delete_customer/{c_id}/agent/{a_id}', [App\Http\Controllers\CustomerController::class, 'remove_customer_from_agent'])->name('remove_customer_from_agent');
Route::post('/importcustomers/bulk', [App\Http\Controllers\CustomerController::class, 'import_customers'])->name('import_customers');
Route::get('/download_customers/sample', [App\Http\Controllers\CustomerController::class, 'download_sample'])->name('download_sample');
Route::get('/check_customer', [App\Http\Controllers\CustomerController::class, 'check_customer_by_phone'])->name('check_customer_by_phone');


//Payments route 
Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'index'])->name('show_payment');
Route::post('/payment', [App\Http\Controllers\PaymentController::class, 'get_t_list'])->name('generate_pay');
Route::post('/pay/single/transaction', [App\Http\Controllers\PaymentController::class, 'pay_single_t'])->name('pay_single_t');
Route::post('/pay/all/transaction', [App\Http\Controllers\PaymentController::class, 'pay_all_tran_p_c'])->name('pay_all_tran_p_c');
Route::post('/pay/all/customers', [App\Http\Controllers\PaymentController::class, 'pay_all_tran_p_c_bulk'])->name('pay_all_tran_p_c_bulk');
Route::get('/customer_name_search_p', [App\Http\Controllers\PaymentController::class, 'customer_search'])->name('customer_p');


//gateway details
Route::get('/profile/gateway/opt/eyowo', [App\Http\Controllers\PaymentGatewayController::class, 'add_update_gateway_details'])->name('add_update_gateway_details');
// Route::get('/gateway/otp/{info}/{val_info}/eyowo', [App\Http\Controllers\PaymentGatewayController::class, 'show_otp_eyowo'])->name('show_otp_eyowo');
Route::post('/otp_e', [App\Http\Controllers\PaymentGatewayController::class, 'verify_otp_eyowo'])->name('verify_otp_eyowo');


// Tansactions route 
Route::get('/transactions', [App\Http\Controllers\transactionController::class, 'index'])->name('show_transactions');
Route::post('/transactions', [App\Http\Controllers\transactionController::class, 'get_transaction_list'])->name('get_transaction_list');
Route::get('/data_search_t', [App\Http\Controllers\transactionController::class, 'search_data_t'])->name('search_data_t');


//plans
Route::get('/plan', [App\Http\Controllers\PlanController::class, 'index'])->name('plan_index');
Route::get('/plan/upgrade/{id}/{p_d}', [App\Http\Controllers\PlanController::class, 'plan_show_upgrade'])->name('plan_show_upgrade');
Route::post('/plan/pay/{id}', [App\Http\Controllers\PlanController::class, 'pay'])->name('plan_pay');
Route::post('/plan/upgrade', [App\Http\Controllers\PlanController::class, 'plan_upgrade'])->name('plan_upgrade');
Route::post('/plan/pay', [App\Http\Controllers\PlanController::class, 'add_plan_detail'])->name('plan_add');
Route::get('/plan/callback', [App\Http\Controllers\PlanController::class, 'payment_callback'])->name('plan_pay_callback');

// Pdf route
Route::get('/pdf/agent/{username}/customers', [App\Http\Controllers\PdfController::class, 'get_customers'])->name('export_customers_pdf');

// 
// **** MAIN ADMIN ROUTES (END) ****
// 

// \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// |||||||||||||||||||||||MUKTAR USMAN ALIYU (mualiyuoox@gmail.com)||||||||||||||||||||||||||||||
// /////////////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////////

// 
// **** AGENTS ROUTES (START) ****
// 
Route::get('/agent/dashboard', [App\Http\Controllers\Agents\HomeController::class, 'index'])->name('agent_dashboard');
// Agent Auth 
Route::post('/agent/login', [App\Http\Controllers\Agents\AuthController::class, 'login'])->name('agent_dashboard_login');
// Agent Profile
Route::get('/agent/profile', [App\Http\Controllers\Agents\HomeController::class, 'show_agent_profile'])->name('agent_show_agent_profile');
Route::post('/agent/update_agent/{id}', [App\Http\Controllers\Agents\HomeController::class, 'update_agent'])->name('agent_update_agent');
// agent CUstomers
Route::get('/agent/dashboard/customers', [App\Http\Controllers\Agents\CustomerController::class, 'index'])->name('agent_show_customers');
Route::get('/agent/dashboard/customer/add', [App\Http\Controllers\Agents\CustomerController::class, 'show_add_customer'])->name('agent_show_add_customer');
Route::post('/agent/dashboard/customer/add', [App\Http\Controllers\Agents\CustomerController::class, 'create_customer'])->name('agent_create_customer');
// Route::post('/agent/dashboard/update_customer/{id}', [App\Http\Controllers\Agents\CustomerController::class, 'update_customer'])->name('agent_update_customer');
Route::post('/agent/dashboard/add_customer_to_agent', [App\Http\Controllers\Agents\CustomerController::class, 'add_customer_to_agent'])->name('agent_add_customer_to_agent');
Route::post('/agent/dashboard/delete_customer/{id}', [App\Http\Controllers\Agents\CustomerController::class, 'delete_customer'])->name('agent_delete_customer');
Route::get('/agent/download_customers/sample', [App\Http\Controllers\Agents\CustomerController::class, 'download_sample'])->name('agent_download_sample');
Route::get('/agent/dashboard/check_customer', [App\Http\Controllers\Agents\CustomerController::class, 'check_customer_by_phone'])->name('agent_check_customer_by_phone');
Route::post('/agent/importcustomers/bulk', [App\Http\Controllers\Agents\CustomerController::class, 'import_customers'])->name('agent_import_customers');
// Agent transaction
Route::get('/agent/dashboard/transactions', [App\Http\Controllers\Agents\TransactionController::class, 'index'])->name('agent_show_transactions');
Route::post('/agent/dashboard/transactions', [App\Http\Controllers\Agents\TransactionController::class, 'get_transaction_list'])->name('agent_get_transaction_list');
Route::get('/agent/dashboard/data_search_t', [App\Http\Controllers\Agents\TransactionController::class, 'search_data_t'])->name('agent_search_data_t');


// 
// **** AGENTS ROUTES (END) ****
// 
