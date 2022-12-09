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

$controller_path = 'App\Http\Controllers';

Route::middleware('auth')->group(function () {
        $controller_path = 'App\Http\Controllers';
       
        // Main Page Route
        Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard');

        //Clients
        // Route::get('/clients', $controller_path.'\ClientController@index')->name('clients');
        // Route::get('/clients', $controller_path.'\ClientController@index')->name('clients');
        Route::resource('clients',$controller_path.'\ClientController',['names'=>'clients']);
        Route::resource('loans', $controller_path.'\LoanController',['names'=>'loans']);
        Route::resource('payments', $controller_path.'\PaymentController',['names'=>'payments']);
        Route::post('/payments/pay', $controller_path.'\PaymentController@pay')->name('payments.index');
        Route::get('/payments/post', $controller_path.'\PaymentController@postPay')->name('payments.index');
        
});

// authentication
Route::get('/auth/login', $controller_path . '\authentications\LoginBasic@index')->name('login');
Route::post('/validate-login', $controller_path . '\authentications\LoginBasic@validate_login')->name('validate-login');
Route::get('/auth/logout', $controller_path . '\authentications\LoginBasic@logout')->name('logout');

Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');