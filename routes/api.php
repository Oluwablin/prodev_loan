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

    Route::group(['prefix' => 'loan'], function () {
        Route::post('/create', ['uses' => 'Loan\LoanController@createLoan']);
        Route::put('/update/{id}', ['uses' => 'Loan\LoanController@updateLoan']);
        Route::get('/view/{id}', ['uses' => 'Loan\LoanController@viewLoan']);
        Route::get('/list', ['uses' => 'Loan\LoanController@listLoan']);
        Route::delete('/delete/{id}', ['uses' => 'Loan\LoanController@deleteLoan']);

        //Admin
        Route::group(['middleware' => ['role:admin']], function () {
            Route::post('/approve', ['uses' => 'Loan\LoanController@approveLoan']);
            Route::post('/decline', ['uses' => 'Loan\LoanController@declineLoan']);
        });
        
    });

});
