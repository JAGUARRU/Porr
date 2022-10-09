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

    //Route::get('employees', [EmployeeController::class, 'index'])->name('employees');
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
    Route::resource('products', \App\Http\Controllers\ProductsController::class);
    Route::resource('trucks', \App\Http\Controllers\TrucksController::class);

    Route::resource('orders', \App\Http\Controllers\OrdersController::class);

    Route::get('/reports/sales', [ReportController::class, 'monthly_sales'])->name('reports.sales');
    Route::get('/reports/orders', [ReportController::class, 'monthly_orders'])->name('reports.orders');
    Route::get('/reports/compare', [ReportController::class, 'monthly_compare'])->name('reports.compare');

    Route::get('/reports/sales/pdf', [ReportController::class, 'sales_pdf'])->name('reports.sales_pdf');
    Route::get('/reports/orders/pdf', [ReportController::class, 'orders_pdf'])->name('reports.orders_pdf');
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