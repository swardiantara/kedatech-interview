<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    
    Route::get('userList','AuthController@getUserList');
});

Route::group(['prefix' => 'customer'], function() {
    Route::get('', [StaffController::class, 'getCustomer']);
    Route::delete('{userId}', [StaffController::class, 'deleteCustomer']);
    Route::post('message', [CustomerController::class, 'sendMessage']);
    Route::post('report', [CustomerController::class, 'createReport']);
    Route::get('{receiverId}/conversation', [CustomerController::class, 'conversationWith']);
});

Route::group(['prefix' => 'staff'], function() {
    Route::post('message', [StaffController::class, 'sendMessage']);
    Route::get('message', [StaffController::class, 'getAllMessages']);
    Route::get('{receiverId}/conversation', [StaffController::class, 'conversationWith']);
});