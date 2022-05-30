<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RetailController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\TruckRouteController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\GeneratorController;

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

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('forms', 'forms')->name('forms');
    Route::view('cards', 'cards')->name('cards');
    Route::view('charts', 'charts')->name('charts');
    Route::view('buttons', 'buttons')->name('buttons');
    Route::view('modals', 'modals')->name('modals');
    Route::view('tables', 'tables')->name('tables');
    Route::view('calendar', 'calendar')->name('calendar');

    //Route::post('save' , [GeneratorController::class, 'save'])->name('generate.save');

    Route::get('employees', [EmployeeController::class, 'index'])->name('employees');
    Route::get('add-employee', [EmployeeController::class, 'create']);
    Route::post('add-employee', [EmployeeController::class, 'store']);
    Route::get('edit-employee/{emp_id}', [EmployeeController::class, 'edit']);
    Route::put('update-employee/{emp_id}', [EmployeeController::class, 'update']);
    Route::delete('/delete-employee/{emp_id}', [EmployeeController::class, 'destroy'])->name('delete-employee.destroy');


    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('add-product', [ProductController::class, 'create']);
    Route::post('add-product', [ProductController::class, 'store']);
    Route::get('edit-product/{prod_id}', [ProductController::class, 'edit']);
    Route::put('update-product/{prod_id}', [ProductController::class, 'update']);
    Route::delete('/delete-product/{prod_id}', [ProductController::class, 'destroy'])->name('delete-product.destroy');

    Route::resource('categories', ProductCategoryController::class);

    Route::get('retail', [RetailController::class, 'index'])->name('retail');
    Route::get('add-retail', [RetailController::class, 'create']);
    Route::post('add-retail', [RetailController::class, 'store']);
    Route::get('edit-retail/{retail_id}', [RetailController::class, 'edit']);
    Route::put('update-retail/{retail_id}', [RetailController::class, 'update']);
    Route::delete('/delete-retail/{retail_id}', [RetailController::class, 'destroy'])->name('delete-retail.destroy');

    Route::get('truck', [TruckController::class, 'index'])->name('truck');
    Route::get('add-truck', [TruckController::class, 'create']);
    Route::post('add-truck', [TruckController::class, 'store']);
    Route::get('edit-truck/{truck_id}', [TruckController::class, 'edit']);
    Route::put('update-truck/{truck_id}', [TruckController::class, 'update']);
    Route::delete('/delete-truck/{truck_id}', [TruckController::class, 'destroy'])->name('delete-truck.destroy');

    Route::view('truck_route', 'trucks.truck_route')->name('truck_route');
});
