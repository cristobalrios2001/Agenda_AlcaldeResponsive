<?php

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

Route::get('/', function () {
    return view('auth.login');
});

//Auth::routes();
Auth::routes(['register'=>false]);

// Route::post('/changePassword', [App\Http\Controllers\Auth\ChangePassword::class, 'changePassword'])->name('passwordUpdate');

// Route::post('/verificarEmail', [App\Http\Controllers\Auth\ChangePassword::class, 'verificarEmail'])->name('verificarEmail');



// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

// Route::get('password/reset/{token}', 'Auth\ForgotPasswordController@showResetForm')->name('password.reset');

// Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/send', [App\Http\Controllers\HomeController::class, 'send'])->name('send');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/store', [App\Http\Controllers\HomeController::class, 'store'])->name('store');

Route::post('/update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('update');

Route::delete('/destroy/{id}', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete');

Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');

Route::get('/obtenerDatosFechas', [App\Http\Controllers\HomeController::class, 'obtenerDatosFechas'])->name('obtenerDatosFechas');
