<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/add/{id}/{deviceType}/{deviceId}', 'SensorController@add')->name('sensor.add');
Route::prefix('control')->group(function(){
    Route::get('/{id}/{deviceType}', 'SensorController@update')->name('sensor.update');
    Route::get('/update/{userId}/{deviceType}/{deviceId}', 'SensorController@control')->name('control.add');
});
Route::get('/download/{userId}/{deviceId}', 'SensorController@download')->name('sensor.download');
Route::get('/lamp/{userId}/{deviceType}/{deviceId}', 'ArduinoController@lamp')->name('arduino.lamp');
Route::get('/read/{id}/{deviceType}/{deviceId}', 'SensorController@read')->name('sensor.read');
Route::get('/rooms','RoomController@list')->name('room.list');
Route::get('/devices/{id}','API\ArduinoController@index')->name('api.arduino.list');
Route::get('/chart/{userId}', 'SensorController@chart')->name('sensor.chart');
Route::get('/control/{userId}', 'ControlController@read')->name('api.control');
Route::get('/message/{userId}', 'NotificationController@security')->name('api.notification');
