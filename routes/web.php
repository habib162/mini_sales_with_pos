<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'admin_login'])->name('admin.login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');


Route::group(['namespace' => 'App\Http\Controllers\admin', 'middleware' => 'is_admin'],function(){
    Route::get('/admin/home', 'AdminController@admin')->name('admin.home');
    Route::get('/admin/logout', 'AdminController@logout')->name('admin.logout');
    Route::get('/admin/password/change', 'AdminController@PasswordChange')->name('admin.password.change');
    Route::post('/admin/password/update', 'AdminController@PasswordUpdate')->name('admin.password.update');

// // product routes
Route::prefix('product')->group(function(){ 
     Route::get('/', 'ProductController@index')->name('product.index');
     Route::get('/create', 'ProductController@create')->name('product.create');
    Route::post('/store', 'ProductController@Store')->name('product.store');
    Route::get('/delete/{id}', 'ProductController@Destroy')->name('product.destroy');
    Route::get('/edit/{id}', 'ProductController@edit')->name('product.edit');
    Route::post('/update', 'ProductController@update')->name('product.update');
    });
// // product routes
Route::prefix('customer')->group(function(){ 
     Route::get('/', 'CustomerController@index')->name('customer.index');
     Route::get('/create', 'CustomerController@create')->name('customer.create');
    Route::post('/store', 'CustomerController@Store')->name('customer.store');
    Route::get('/delete/{id}', 'CustomerController@Destroy')->name('customer.destroy');
    Route::get('/edit/{id}', 'CustomerController@edit')->name('customer.edit');
    Route::post('/update', 'CustomerController@update')->name('customer.update');
    });
Route::prefix('sale')->group(function(){ 
     Route::get('/', 'SaleController@index')->name('sale');
     Route::post('/pos', 'SaleController@addToCart')->name('posaddtocart');
     Route::post('/deletecart', 'SaleController@deleteCartItem')->name('deletecartitem');
     Route::post('/deleteallcart', 'SaleController@deleteAllCartItem')->name('deleteallcartitem');
     Route::post('/invoice', 'SaleController@itemSellInvoiceShow')->name('sellInvoice.show');
     Route::get('/invoice/create', 'SaleController@create')->name('invoice.create');
     Route::post('/deletecurrentcart', 'SaleController@deletecurrentcart');
     Route::get('/generate-invoice-pdf', array('as'=> 'generate.invoice.pdf', 'uses' => 'SaleController@generateInvoicePDF'));
    });
});