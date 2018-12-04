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

Route::get('/', 'MainpageController@index');

//Route::get('/test/', 'TestController');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/add-to-cart', 'ProductController@addToCart');

Route::group(['prefix' => 'personal'], function () {
    Route::get('cart', 'PersonalController@cart');
});
