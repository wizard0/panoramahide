<?php

use \Illuminate\Support\Facades\Route;
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

});

//Auth::routes();



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

Route::group(['prefix' => 'magazines'], function () {
    Route::get('/', 'MagazinesController')->name('journals');
    Route::get('/{code}.html', 'MagazinesController@detail')->name('journal');
    Route::get('/ajax-get-page', 'MagazinesController@ajaxGetPage');
    Route::post('/send-article', 'MagazinesController@sendArticle')->name('send.article');

    Route::get('/{journalCode}/numbers/{releaseID}.html', 'ReleaseController@detail')->name('release');
});

Route::get('/articles/{code}.html', 'ArticlesController@detail')->name('article');

Route::group(['prefix' => 'publishers'], function () {
    Route::get('/', 'PublishersController')->name('publishers');
    Route::get('/{code}', 'PublishersController@detail')->name('publisher');
});

Route::get('/categories', 'CategoriesController')->name('categories');

Route::post('/recommend', 'AjaxActionsController@recommend')->name('recommend');
Route::post('/add-to-favorite', 'AjaxActionsController@addToFavorite')->middleware('auth')->name('to.favorite');
Route::any('/print-abonement', 'AjaxActionsController@printAbonement')->name('print.abonement');

Route::group(['prefix' => 'search'], function () {
    Route::get('/', 'SearchController')->name('search');
    Route::post('/', 'SearchController');
    Route::post('/save', 'SearchController@saveSearch')->middleware('auth')->name('save.search');
    Route::get('/get', 'SearchController@getSaved')->middleware('auth')->name('get.search');
    Route::post('/delete', 'SearchController@deleteSearch')->middleware('auth')->name('delete.search');
});


Route::get('/logout', 'PersonalController@logout');

//Route::post('/login', 'PersonalController@login')->name('login');
Route::post('/auth/register', 'Auth\RegisterController@register')->name('register');
Route::post('/auth/login', 'Auth\LoginController@login')->name('login');
Route::post('/auth/code', 'Auth\RegisterController@code')->name('code');

Route::group(['prefix' => 'promo'], function () {
    Route::get('/', 'PromoController@index')->name('promo.index');
    Route::post('/access', 'PromoController@access')->name('promo.access');
    Route::post('/code', 'PromoController@code')->name('promo.code');
    Route::post('/password', 'PromoController@password')->name('promo.password');
    Route::post('/activation', 'PromoController@activation')->name('promo.activation');
});

Route::group(['prefix' => 'deskbooks'], function () {
    Route::get('/', 'PromoController@deskbooks')->name('deskbooks.index');
    Route::post('/save', 'PromoController@save')->name('deskbooks.save');
});
Route::group(['prefix' => 'reader'], function () {
    Route::get('/', 'ReaderController@index')->name('reader.index');
    Route::post('/code', 'ReaderController@code')->name('reader.code');
    Route::get('/reset/{code}', 'ReaderController@reset')->name('reader.reset');
    Route::any('/online', 'ReaderController@online')->name('reader.online');
    Route::any('/release', 'ReaderController@release')->name('reader.release');
    Route::any('/releases', 'ReaderController@releases')->name('reader.releases');
    Route::any('/articles', 'ReaderController@articles')->name('reader.articles');
    Route::group(['prefix' => 'favorites'], function () {
        Route::get('/', 'ReaderController@favorites')->name('reader.favorites');
    });
    Route::group(['prefix' => 'bookmarks'], function () {
        Route::any('/', 'ReaderController@bookmarks')->name('reader.bookmarks');
        Route::post('/{id}/destroy', 'ReaderController@bookmarksDestroy')->name('reader.bookmarks.destroy');
        Route::post('/create', 'ReaderController@bookmarksCreate')->name('reader.bookmarks.create');
    });
});

Route::group(['prefix' => 'home'], function () {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/journals', 'HomeController@journals')->name('home.journals');
    Route::post('/journals/save', 'HomeController@journalsSave')->name('home.journals.save');
});
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

