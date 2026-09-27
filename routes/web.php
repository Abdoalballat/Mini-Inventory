<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InvoiceItemsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::middleware('users')->group(function(){

    Route::controller(ProductsController::class)->group(function()
    {
        Route::get('products/index','index')->name('products.index');
        Route::post('products/store','store')->name('products.store');
        Route::get('products/create','create')->name('products.create');
        Route::get('products/edit/{id}','edit')->name('products.edit');
        Route::patch('products/update/{id}','update')->name('products.update');
        Route::delete('products/destroy/{id}','destroy')->name('products.destroy');
        Route::get('products/show/{id}','show')->name('products.show');
        });

    Route::controller(InvoicesController::class)->group(function(){
        Route::get('invoices/index','index')->name('invoices.index');
        Route::delete('invoices/destroy/{id}','destroy')->name('invoices.destroy');
        Route::post('invoice/store','store')->name('invoices.store');
        Route::get('invoice/show/{id}','show')->name('invoices.show');
        });

    Route::controller(InvoiceItemsController::class)->group(function(){
        Route::get('invoice_items/index','index')->name('invoice_items.index');
        Route::get('invoice_items/create','create')->name('invoice_items.create');
        Route::post('invoice_items/store','store')->name('invoice_items.store');
        Route::patch('invoice_items/update/{id}','update')->name('invoice_items.update');
    });

});

Route::controller(LoginController::class)->group(function(){
    Route::post('login/register','register')->name('login.register');
    Route::post('login/login','login')->name('login.login');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
    Route::get('/login','showLoginForm')->name('login.page');
});

Route::controller(ForgotPasswordController::class)->group(function (){

    Route::get('/forgot-password','showForgotForm')->name('password.request');
    Route::post('/send-otp','sendOtp')->name('send.otp');
    Route::get('/verify-otp','showVerifyOtpForm')->name('password.reset'); //not sets
    Route::post('/verify-otp','verify_otp')->name('verify.otp');
    Route::get('/reset-password','showResetForm')->name('password.reset.form');
    Route::post('/reset-password','resetPassword')->name('password.update');
});
