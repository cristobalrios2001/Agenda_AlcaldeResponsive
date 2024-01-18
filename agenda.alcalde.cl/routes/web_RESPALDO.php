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
Auth::routes(['register'=>false,'reset'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');

Route::post('/store', [App\Http\Controllers\HomeController::class, 'store'])->middleware('auth')->name('store');

Route::post('/update/{id}', [App\Http\Controllers\HomeController::class, 'update'])->middleware('auth')->name('update');

Route::delete('/destroy/{id}', [App\Http\Controllers\HomeController::class, 'delete'])->middleware('auth')->name('delete');

Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->middleware('auth')->name('search');

Route::get('/obtenerDatosFechas', [App\Http\Controllers\HomeController::class, 'obtenerDatosFechas'])->name('obtenerDatosFechas');