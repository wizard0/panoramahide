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
Route::get('/test', function() {

    $p = \App\Promocode::getOne(29);
    foreach($p->getReleases('GRP6') as $r)
        dump($r->id);
    dd('wer');
    for($i=0;$i<10;$i++){
        $groups = [['name' => 'GRP'.rand(1,9), 'journals' => [1,2,3,4,5]],
                   ['name' => 'GRP'.rand(10,19), 'journals' => [3,2,13,4,15]]];
        \App\Promocode::store(['promocode' => 'PC'.rand(100000,999999), 'groups' => $groups]);
    }
    for($i=0;$i<10;$i++){
        \App\Promocode::store(['promocode' => 'PC'.rand(100000,9999999), 'releases' => [3,2,13,4,15]]);
        \App\Promocode::store(['promocode' => 'PC'.rand(100000,9999999), 'journals' => [3,2,13,4,15]]);
        \App\Promocode::store(['promocode' => 'PC'.rand(100000,9999999), 'publishings' => [3,9,10,4,8]]);
    }

    //\App\Promocode::store(['promocode' => 'PC'.rand(1000,9999), 'groups' => $groups]);
    //$p = \App\Promocode::getOne(29);
    $groups = [['name' => 'GRP'.rand(1,9), 'journals' => [1,2,3,4,5]],
               ['name' => 'GRP'.rand(10,19), 'journals' => [3,2,13,4,15]]];
    $p = \App\Promocode::updateOne(29, ['releases' => [3,2,13,15], 'journals' => [2,3,4,5], 'groups' => $groups]);
    dump($p);
    dump($p->releases);
    dump($p->journals);
    dump($p->publishings);
    foreach($p->groups as $group) {
        dump($group->name);
        dump($group->journals);
    }
    dd('ok');
})->name('test');

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
