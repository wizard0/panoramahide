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

Route::get('/', 'MainpageController@index')->name('index');

//Route::get('/test/', 'TestController');


Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'Admin\LoginController')->name('admin.login');
    Route::post('/login', 'Admin\LoginController@login');

    Route::group(['middleware' => ['permission:' . \App\User::PERMISSION_ADMIN]], function () {
        Route::get('/', 'Admin\DashboardController')->name('admin');
        Route::get('/dashboard', 'Admin\DashboardController')->name('admin.dashboard');

        // CRUD
        Route::group(['prefix' => 'content-management'], function () {
            Route::resource('categories', 'Admin\CategoryController');
            Route::resource('publishings', 'Admin\PublishingController');
            Route::resource('authors', 'Admin\AuthorController');
            Route::resource('journals', 'Admin\JournalController');
            Route::resource('releases', 'Admin\ReleaseController');
            Route::resource('articles', 'Admin\ArticleController');

            Route::resource('news', 'Admin\NewsController');

            Route::resource('subscriptions', 'Admin\SubscriptionController');
            Route::resource('paysystems', 'Admin\PaysystemController');
            Route::resource('order_phys_users', 'Admin\OrderPhysUserController');
            Route::resource('order_legal_users', 'Admin\OrderLegalUserController');
            Route::resource('orders', 'Admin\OrderController');
            Route::resource('promocodes', 'Admin\PromocodeController');
            Route::resource('promo_userz', 'Admin\PromoUserController');
            Route::resource('jby_promo', 'Admin\JbyPromoController');
            Route::resource('partners', 'Admin\PartnerController');
            Route::resource('quotas', 'Admin\QuotaController');
            Route::resource('partner_users', 'Admin\PartnerUserController');
            Route::resource('users', 'Admin\UserController');
            Route::resource('roles', 'Admin\RoleController');
        });
    });
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

