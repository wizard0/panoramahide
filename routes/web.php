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

Route::get('/', 'MainpageController@index')->name('index');

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

    Route::group(['prefix' => 'robokassa'], function (){
        Route::get('result_receiver', 'PaymentController@robokassaResult');
        Route::get('success', 'PaymentController@robokassaSuccess');
        Route::get('fail', 'PaymentController@robokassaFail');
    });

    Route::get('order/payment', 'PaymentController@payment')->name('personal.order.payment');
});

Route::get('/magazines', 'MagazinesController')->name('magazines');
Route::get('/magazines/{code}.html', 'MagazinesController@detail')->name('magazine');

Route::post('/recommend', 'AjaxActionsController@recommendJournal')->name('recommend');
Route::post('/add-to-favorite', 'AjaxActionsController@addToFavorite')->middleware('auth')->name('to.favorite');

Route::get('/search', 'SearchController')->name('search');
Route::post('/search', 'SearchController');
Route::post('/save-search', 'SearchController@saveSearch')->middleware('auth')->name('save.search');
Route::get('/get-saved-search', 'SearchController@getSaved')->middleware('auth')->name('get.search');
Route::post('/delete-search', 'SearchController@deleteSearch')->middleware('auth')->name('delete.search');

Route::get('/logout', 'PersonalController@logout');

Route::post('/login', 'PersonalController@login')->name('login');
Route::post('/auth/register', 'Auth\RegisterController@register')->name('register');


/**
 * Промо-учасники
 */
Route::resource('promo_users', 'PromoUsersController');
Route::group(['prefix' => 'promo_users'], function () {
    Route::any('/{id}/promocodes', ['uses' => 'PromoUsersController@promocodes', 'as' => 'promo_users.promocodes']);
    Route::any('/{id}/publishings', ['uses' => 'PromoUsersController@publishings', 'as' => 'promo_users.publishings']);
    Route::any('/{id}/releases', ['uses' => 'PromoUsersController@releases', 'as' => 'promo_users.releases']);

    Route::any('/{id}/promocode/{item_id}/activate', ['uses' => 'PromoUsersController@activatePromocode', 'as' => 'promo_users.promocode.activate']);
    Route::any('/{id}/publishing/{item_id}/activate', ['uses' => 'PromoUsersController@activatePublishing', 'as' => 'promo_users.publishing.activate']);
    Route::any('/{id}/release/{item_id}/activate', ['uses' => 'PromoUsersController@activateRelease', 'as' => 'promo_users.release.activate']);
});

