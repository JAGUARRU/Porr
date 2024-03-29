<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TruckRouteController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RetailsController;
use App\Http\Controllers\OrderRouteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TruckLoadController;
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
    return view('auth.login');
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

    Route::get('/datepicker', [HomeController::class,'homePage']);

    //Route::post('save' , [GeneratorController::class, 'save'])->name('generate.save');

    //Route::get('add-employee', [EmployeeController::class, 'create']);
    //Route::post('add-employee', [EmployeeController::class, 'store']);
    //Route::get('edit-employee/{emp_id}', [EmployeeController::class, 'edit']);
    //Route::put('update-employee/{emp_id}', [EmployeeController::class, 'update']);
    //Route::delete('/delete-employee/{emp_id}', [EmployeeController::class, 'destroy'])->name('delete-employee.destroy');


    /*Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('add-product', [ProductController::class, 'create']);
    Route::post('add-product', [ProductController::class, 'store']);
    Route::get('edit-product/{id}', [ProductController::class, 'edit']);
    Route::put('update-product/{id}', [ProductController::class, 'update']);
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('delete-product.destroy');*/

    Route::get('categories/update/{id}', [\App\Http\Controllers\ProductCategoryController::class, 'update'])->name('categories.update');
    Route::resource('categories', ProductCategoryController::class);

    /*Route::get('retail', [RetailController::class, 'index'])->name('retail');
    Route::get('add-retail', [RetailController::class, 'create']);
    Route::post('add-retail', [RetailController::class, 'store']);
    Route::get('edit-retail/{id}', [RetailController::class, 'edit']);
    Route::put('update-retail/{id}', [RetailController::class, 'update']);
    Route::delete('/delete-retail/{id}', [RetailController::class, 'destroy'])->name('delete-retail.destroy');*/

    /*Route::get('truck', [TruckController::class, 'index'])->name('truck');
    Route::get('add-truck', [TruckController::class, 'create']);
    Route::post('add-truck', [TruckController::class, 'store']);
    Route::get('edit-truck/{truck_id}', [TruckController::class, 'edit']);
    Route::put('update-truck/{truck_id}', [TruckController::class, 'update']);
    Route::delete('/delete-truck/{truck_id}', [TruckController::class, 'destroy'])->name('delete-truck.destroy');*/
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', \App\Http\Controllers\UsersController::class);

    Route::resource('retails', \App\Http\Controllers\RetailsController::class);

    Route::patch('products/{id}', [\App\Http\Controllers\ProductsController::class, 'patch'])->name('products.patch');
    Route::resource('products', \App\Http\Controllers\ProductsController::class);

    Route::get('/trucks/product/pdf', [\App\Http\Controllers\TrucksController::class, 'product_print'])->name('trucks.product_print');
    Route::resource('trucks', \App\Http\Controllers\TrucksController::class);

    Route::get('truckloads/{id}/view', [\App\Http\Controllers\TruckLoadController::class, 'view'])->name('truckloads.view');

    Route::get('truckloads/routes', [\App\Http\Controllers\TruckLoadController::class, 'routes'])->name('truckloads.routes');
    Route::get('truckloads/route/{id}/edit', [\App\Http\Controllers\TruckLoadController::class, 'edit'])->name('truckloads.edit_route');
    Route::get('truckloads/route/{id}/view', [\App\Http\Controllers\TruckLoadController::class, 'view_route'])->name('truckloads.view_route');

    Route::get('truckloads/route/{id}/print', [\App\Http\Controllers\TruckLoadController::class, 'print_route'])->name('truckloads.print_route');

    Route::put('truckloads/order/{id}', [\App\Http\Controllers\TruckLoadController::class, 'update_order'])->name('truckloads.update_order');

    Route::get('truckloads/order/{id}', [\App\Http\Controllers\TruckLoadController::class, 'load_order'])->name('truckloads.load_order');
 
    Route::resource('truckloads', \App\Http\Controllers\TruckLoadController::class);

    Route::patch('orders/{id}', [\App\Http\Controllers\OrdersController::class, 'patch'])->name('orders.patch');
    Route::resource('orders', \App\Http\Controllers\OrdersController::class);

    Route::get('/reports/sales', [ReportController::class, 'monthly_sales'])->name('reports.sales');
    Route::get('/reports/compare', [ReportController::class, 'monthly_compare'])->name('reports.compare');

    Route::get('/reports/sales/pdf', [ReportController::class, 'sales_pdf'])->name('reports.sales_pdf');
    Route::get('/reports/compare/pdf', [ReportController::class, 'compare_pdf'])->name('reports.compare_pdf');

    Route::resource('reports', \App\Http\Controllers\ReportController::class);

    
    Route::get('/routes/list', [OrderRouteController::class, 'list']);
    Route::get('/routes/confirm/{id}', [OrderRouteController::class, 'confirm']);
    Route::get('/routes/order', [OrderRouteController::class, 'order']);
    
    Route::post('/routes/confirmRoute', [OrderRouteController::class, 'confirmRoute']);

    Route::resource('routes', \App\Http\Controllers\OrderRouteController::class);

    Route::get('/orders/{search}','OrdersController@search');

    Route::get('/orders/{term}','OrdersController@term');
});