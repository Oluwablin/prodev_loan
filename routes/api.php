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

//TEST
Route::get('test', function () {
    return 'Hello';
});

//Unathenticated Routes
Route::group(['namespace' => 'App\Http\Controllers\Api\v1\Auth', 'prefix' => 'v1/auth'], function () {
    Route::post('/login', ['uses' => 'LoginController@Login']);
    Route::post('/logout', ['uses' => 'LoginController@Logout'])->middleware("auth:api");

});

//Authenticated Routes
Route::group(['middleware' => 'auth:api', 'namespace' => 'App\Http\Controllers\Api\v1', 'prefix' => 'v1'], function () {


});
