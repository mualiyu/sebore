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


//customers
Route::get('/customers/{id}', [App\Http\Controllers\CustomerController::class, 'show_customers'])->name('show_customers');
Route::get('/create_customer/{id}', [App\Http\Controllers\CustomerController::class, 'show_add_customer'])->name('show_add_customer');
Route::get('/customer/{a_id}/edit/{c_id}', [App\Http\Controllers\CustomerController::class, 'show_edit_customer'])->name('show_edit_customer');
Route::post('/create_customer', [App\Http\Controllers\CustomerController::class, 'create_customer'])->name('create_customer');
Route::post('/update_customer/{id}', [App\Http\Controllers\CustomerController::class, 'update_customer'])->name('update_customer');
Route::post('/delete_customer/{id}', [App\Http\Controllers\CustomerController::class, 'delete_customer'])->name('delete_customer');
