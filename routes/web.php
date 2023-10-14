<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('loans', 'LoanController');
Route::get('loans/{loan}/payments/create',      'PaymentController@create')->name('payments.create');
Route::post('loans/{loan}/payments',            'PaymentController@store')->name('payments.store');


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/register',                 'RegisterController@show')->name('register.show');
        Route::post('/register',                'RegisterController@register')->name('register.perform');

        Route::get('/login',                    'LoginController@show')->name('login.show');
        Route::post('/login',                   'LoginController@login')->name('login.perform');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::prefix('loans')->name('loans.')->group(function () {
            Route::get('/',                     'LoanController@index')->name('index');
            Route::get('create',                'LoanController@create')->name('create');
            Route::get('{loan}/show',           'LoanController@show')->name('show');
            Route::post('store',                'LoanController@store')->name('store');
            Route::get('{loan}/approve',        'LoanController@approve')->name('approve');

            Route::prefix('{loan}/payments')->name('payments.')->group(function () {
                Route::get('{payment}/pay',           'PaymentController@pay')->name('pay');
            });
        });


        Route::get('/logout',                   'LogoutController@perform')->name('logout.perform');
    });
});
