<?php

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

/* Route::fallback(function(){
    return response()->json(['error' => 'Normal Resource not found.'], 404);
})->name('fallback'); */

// Route::post('register', 'Auth\RegisterController@register');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout');

Auth::routes();



/* Route::get('/', function () {
    return view('welcome');
}); */
