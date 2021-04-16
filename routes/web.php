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

Route::get('/', function () {
    return view('welcome');
});

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::get('/dashboard', [\App\Http\Controllers\Controller::class, 'index'])->name('dashboard');
});

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['middleware' => 'role:user', 'prefix' => 'user', 'as' => 'users.'], function () {
            Route::resource('user', App\Http\Controllers\User\UserController::class);
            Route::resource('event', App\Http\Controllers\User\EventController::class);
        });

        Route::group(['middleware' => 'role:administrator', 'prefix' => 'admin', 'as' => 'admins.'], function () {
            Route::resource('user', App\Http\Controllers\Admin\UserController::class);
            Route::resource('event', App\Http\Controllers\Admin\EventController::class);
            Route::resource('autofill', App\Http\Controllers\Admin\AutoFillController::class);

        });
    });

