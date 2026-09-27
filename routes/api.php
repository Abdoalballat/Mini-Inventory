<?php

// use App\Http\Controllers\InvoiceItemsController;
// use App\Http\Controllers\InvoicesController;
// use App\Http\Controllers\LoginController;
// use App\Http\Controllers\ProductsController;
// use App\Models\invoice_items;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use PhpParser\Builder\Function_;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



//     Route::controller(LoginController::class)->group(function(){
//     Route::post('login/register','register')->name('login.register');
//     Route::post('login/login','login')->name('login.login');
//     Route::post('login/logout','logout')->name('login.logout')->middleware('auth:sanctum');
//     });

    
//     Route::controller(ProductsController::class)->group(function()
//     {
//         Route::get('products/index','index')->name('products.index');
//         Route::post('products/store','store')->name('products.store');
//         Route::patch('products/update/{id}','update')->name('products.update');
//         Route::delete('products/destroy/{id}','destroy')->name('products.destroy');
//         Route::get('products/show/{id}','show')->name('products.show');
//         });
        
//         Route::middleware('auth:sanctum')->group(function(){
//     Route::controller(InvoicesController::class)->group(function(){
//     Route::get('invoices/index','index')->name('invoices.index');
//     Route::delete('invoices/destroy/{id}','destroy')->name('invoices.destroy');
//     Route::post('invoices/store','store')->name('invoices.store');
//         Route::get('invoice/show/{id}','show')->name('invoices.show');

//     });

//     Route::controller(InvoiceItemsController::class)->group(function(){
//     Route::get('invoice_items/index','index')->name('invoice_items.index');
//     Route::post('invoice_items/store','store')->name('invoices_items.store');
//     Route::patch('invoice_items/update/{id}','update')->name('invoice_items.update');
//     });

//     });
