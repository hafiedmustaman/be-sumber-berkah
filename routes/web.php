<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

/**
 * route for admin
 */

//group route with prefix "admin"
Route::prefix('admin')->group(function () { // <-- Prefix "admin" digunakan untuk menambahkan kata admin di awalan URL.

    //group route with middleware "auth"
    Route::group(['middleware' => 'auth'], function() { // <-- route tersebut hanya bisa di akses jika sudah melakukan authentication atau login.
        
        //route dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

        //route category
        Route::resource('/category', CategoryController::class, ['as' => 'admin']);

        //route product
        Route::resource('/product', ProductController::class, ['as' => 'admin']);

        //route order
        Route::resource('/order', OrderController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy'], 'as' => 'admin']);

        //route customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.index');
    });
});