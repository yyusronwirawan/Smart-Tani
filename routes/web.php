<?php

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
//     return redirect('/login');
// });

// Auth::routes();

// Route::get('/register', );

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/register', 'FirebaseController@index')->name('register');
Route::post('/register','FirebaseController@create')->name('user.create');

Route::get('/login', 'LoginController@index')->name('login');
Route::get('/', 'LoginController@index')->name('login');
Route::post('/login', 'LoginController@user')->name('user.login');

Route::get('/forgot', 'ForgotPasswordController@index')->name('user.forgot');
Route::post('/forgot', 'ForgotPasswordController@reset')->name('user.reset');


Route::group(['middleware' => 'firebase'], function () {
    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('profile')->group(function(){
        Route::get('/','ProfileController@index')->name('profile');
        Route::put('/','FirebaseController@update')->name('user.update');

        Route::put('/email', 'FirebaseController@email')->name('email.update');
        Route::delete('/','FirebaseController@delete')->name('user.delete');
        Route::put('/password', 'PasswordController@update')->name('password.update');
    });

    Route::get('control', 'ControlController@index')->name('control');

    //Arduino
    Route::prefix('device')->group(function() {
        Route::get('/', 'ArduinoController@index')->name('arduino');
        Route::post('/' , 'ArduinoController@create')->name('arduino.create');

        Route::get('/{id}', 'ArduinoController@read')->name('arduino.read');
        Route::put('/{id}', 'ArduinoController@update')->name('arduino.update');
        Route::delete('/{id}', 'ArduinoController@delete')->name('arduino.delete');

        Route::prefix('house/{id}')->group(function() {
            Route::get('/', 'HouseController@read')->name('house.read');
            Route::put('/', 'HouseController@update')->name('house.update');
            Route::delete('/', 'HouseController@delete')->name('house.delete');
            Route::post('/', 'HouseController@create')->name('house.add');

            //Lamp
            Route::prefix('/{lampId}')->group(function() {
                Route::get('/', 'LampController@index')->name('lamp.read');
                Route::put('/', 'LampController@update')->name('lamp.update');
                Route::delete('/', 'LampController@destroy')->name('lamp.delete');
            });
        });
    });
});
