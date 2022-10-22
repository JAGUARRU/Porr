<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TambonController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\ReportController;
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


Route::get('/provinces', [ TambonController::class , 'getProvinces' ]);
Route::get('/amphoes', [TambonController::class , 'getAmphoes' ]);
Route::get('/tambons', [ TambonController::class , 'getTambons' ]);
Route::get('/zipcodes', [TambonController::class, 'getZipcodes'] );

Route::get('/report/salesChart', [ ReportController::class , 'salesChart' ]);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/search', [ SearchController::class , 'search' ])->name('api.search');
    Route::get('/drivers', [ EmployeeController::class , 'getDrivers' ]);
    Route::get('/trucks/load', [ SearchController::class , 'truck_load' ])->name('api.available_truck_load');
    Route::get('/trucks/route', [ SearchController::class , 'truck_route' ])->name('api.available_truck_route');
});