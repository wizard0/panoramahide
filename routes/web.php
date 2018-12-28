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

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/add-to-cart', 'ProductController@addToCart');
Route::post('/delete-from-cart', 'ProductController@deleteFromCart');

Route::group(['prefix' => 'personal'], function () {
    Route::get('/', 'PersonalController@index')->name('personal');

    Route::get('cart', 'PersonalController@cart')
        ->name('cart');
    Route::get('order/make', 'PersonalController@orderMake')
        ->name('order.make');
    Route::post('order/make', 'PersonalController@processOrder');
    Route::get('order/complete/{id}', 'PersonalController@completeOrder')
        ->name('order.complete');

    Route::group(['prefix' => 'robokassa'], function () {
        Route::get('result_receiver', 'PaymentController@robokassaResult');
        Route::get('success', 'PaymentController@robokassaSuccess');
        Route::get('fail', 'PaymentController@robokassaFail');
    });

    Route::get('order/payment', 'PaymentController@payment')->name('personal.order.payment');
});

Route::get('/magazines', 'MagazinesController')->name('magazines');
Route::get('/magazines/{code}.html', 'MagazinesController@detail')->name('magazine');
Route::get('/articles/{code}.html', 'ArticlesController@detail')->name('article');
Route::get('/magazines/{journalCode}/numbers/{releaseCode}.html', 'ReleasesController@detail')->name('release');

Route::post('/recommend', 'AjaxActionsController@recommend')->name('recommend');
Route::post('/add-to-favorite', 'AjaxActionsController@addToFavorite')->middleware('auth')->name('to.favorite');

Route::group(['prefix' => 'search'], function () {
    Route::get('/', 'SearchController')->name('search');
    Route::post('/', 'SearchController');
    Route::post('/save', 'SearchController@saveSearch')->middleware('auth')->name('save.search');
    Route::get('/get', 'SearchController@getSaved')->middleware('auth')->name('get.search');
    Route::post('/delete', 'SearchController@deleteSearch')->middleware('auth')->name('delete.search');
});


Route::get('/logout', 'PersonalController@logout');

Route::post('/login', 'PersonalController@login')->name('login');
