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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','Login\LoginController@login');
Route::post('/logindo','Login\LoginController@logindo');


Route::get('/login/reg','Login\LoginController@reg');
Route::post('/regdo','Login\LoginController@regdo');

Route::get('/index','Login\LoginController@index');



