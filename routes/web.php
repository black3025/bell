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
        Route::resource('clients',$controller_path.'\ClientController',['names'=>'clients']);
        //loans
        Route::resource('loans', $controller_path.'\LoanController',['names'=>'loans']);
        Route::post('/loans/updateLoan',$controller_path.'\LoanController@updateLoan');
        //payments
        Route::resource('payments', $controller_path.'\PaymentController',['names'=>'payments']);
        Route::post('/payments/pay', $controller_path.'\PaymentController@pay')->name('payments.index');
        Route::get('/payments/post', $controller_path.'\PaymentController@postPay')->name('payments.index');
         //reports
         Route::resource('reports',$controller_path.'\ReportController',['names'=>'reports']);
        
        
        //reports
        Route::post('/report/daily',$controller_path.'\ReportController@dcrAll');
        Route::post('/report/dailyPrint',$controller_path.'\ReportController@dailyPrint');
        Route::post('/report/dailyNo',$controller_path.'\ReportController@dailyNo');
        Route::post('/report/SOA', $controller_path.'\ReportController@SOA');
        Route::post('/report/newAccount', $controller_path.'\ReportController@newAccount');
        Route::post('/report/ncr', $controller_path.'\ReportController@ncr');
        Route::post('/report/targetPerformance',$controller_path.'\ReportController@targetPerformance');
        
        //admin only
        Route::resource('users', $controller_path.'\UserController',['names'=>'users']);
        //admin-users
        Route::get('users/status_change/{id}',$controller_path.'\UserController@status');
        Route::get('users/resetPW/{id}',$controller_path.'\UserController@resetPW');
        Route::post('/users/updatePass',$controller_path.'\UserController@updatePass');
        //admin-role
        Route::resource('roles', $controller_path.'\RoleController',['names'=>'roles']);
        Route::get('roles/status_change/{id}',$controller_path.'\RoleController@status');
        Route::post('roles/update/{id}',$controller_path.'\RoleController@updateR');
        //admin-area
        Route::resource('areas',$controller_path.'\AreaController',['names'=>'areas']);
        Route::get('areas/status_change/{id}',$controller_path.'\AreaController@status');
        Route::post('areas/update/{id}',$controller_path.'\AreaController@updateR');
       
});

// authentication
Route::get('/auth/login', $controller_path . '\authentications\LoginBasic@index')->name('login');
Route::post('/validate-login', $controller_path . '\authentications\LoginBasic@validate_login')->name('validate-login');
Route::get('/auth/logout', $controller_path . '\authentications\LoginBasic@logout')->name('logout');

Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');