<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;
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

//company controller
Route::get('companies',[CompanyController::class,'index']);
Route::post('/companies',[CompanyController::class,'store']);
Route::put('/company/{id}',[CompanyController::class,'update']);
Route::delete('/company/{id}',[CompanyController::class,'destroy']);

//employee controller
Route::get('employees',[EmployeeController::class,'index']);
Route::post('/employees',[EmployeeController::class,'store']);
Route::put('/employee/{id}',[EmployeeController::class,'update']);
Route::delete('/employee/{id}',[EmployeeController::class,'destroy']);

