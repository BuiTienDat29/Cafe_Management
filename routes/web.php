<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Table;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Trang gốc → vào products
Route::get('/', function () {
    return redirect()->route('products.index');
});

// Auth
Auth::routes();

// Protected routes
Route::middleware(['auth'])->group(function () {

    // Home
    Route::get('/home', 'HomeController@index')->name('home');

    // Products
    Route::resource('products', 'ProductController');

    // Dashboard
    Route::get('/dashboard', 'ProductController@dashboard')->name('dashboard');

    // Orders
    Route::get('/orders/create', 'OrderController@create')->name('orders.create');
    Route::post('/orders', 'OrderController@store')->name('orders.store');

    // API tables
    Route::get('/api/tables', function () {
        return \App\Models\Table::all(); // ❗ FIX
    });
    Route::post('/orders/{id}/pay', 'OrderController@pay')->name('orders.pay');
    Route::get('/orders/table/{id}', 'OrderController@showByTable');
    Route::post('/orders/complete/{id}', 'OrderController@complete');
    Route::get('/revenue', 'RevenueController@index')->name('revenue.index');
    Route::get('/revenue/data', 'RevenueController@data');

});