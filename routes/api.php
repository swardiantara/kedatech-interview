<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\AuthController;

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
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.verify');
});

Route::group([
    "prefix" => "messages",
], function() {
    Route::post('', [UserController::class, 'sendMessage']); //oke 5 testcase
    Route::get('', [StaffController::class, 'getAllMessages']);
});

Route::group([
    "prefix" => "reports",
], function() {
    Route::post('', [CustomerController::class, 'createReport']);
    Route::get('', [StaffController::class, 'getAllReports']);
});

Route::group([
    'prefix' => 'customers',
], function() {
    Route::get('', [StaffController::class, 'getAllCustomers']);
    Route::delete('{userId}', [StaffController::class, 'deleteCustomer']);
    Route::get('conversation/{receiverId}', [UserController::class, 'conversationWith']);
});

Route::group([
    'prefix' => 'staff'
], function() {
    Route::get('conversation/{receiverId}', [UserController::class, 'conversationWith']);
});
