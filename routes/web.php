<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//Artisan::call('view:clear');

Route::get('/', ['as' => 'main', 'uses' => 'IndexController@index']);
Route::match(['get', 'post'], '/home', ['as' => 'home', 'uses' => 'IndexController@index']);
//Auth::routes();
Route::auth();


Route::group(['middleware' => 'auth'], function () {
    $a = 'authenticated.';
    Route::get('/logout', ['as' => $a . 'logout', 'uses' => 'Auth\LoginController@logout']);
    Route::get('/activate/{token}', ['as' => $a . 'activate', 'uses' => 'ActivateController@activate']);
    Route::get('/activate', ['as' => $a . 'activation-resend', 'uses' => 'ActivateController@resend']);
    Route::get('not-activated', ['as' => 'not-activated', 'uses' => function () {
        return view('errors.not-activated');
    }]);

});

Route::group(['prefix' => 'profile', 'middleware' => ['auth']], function () {

    Route::get('/', ['as' => 'profile', 'uses' => 'ProfileController@mainIndex']);
    Route::get('/order/{id}', ['as' => 'profile.order.cansel', 'uses' => 'ProfileController@canselOrder']);
    Route::get('/order/d/{id}', ['as' => 'profile.order.delete', 'uses' => 'OrderController@getDeleteOrder']);


});
//Route::post('logout', ['as' => 'logout', 'uses' => '\App\Http\Controllers\Auth\LoginController@logout']);
//Route::get('logout', ['uses' => '\App\Http\Controllers\Auth\LoginController@logout']);

Route::get('maketree', ['uses' => 'CategoriesTreeController@index']);
Route::get('maketree/cat', ['uses' => 'CategoriesTreeController@getCategory']);
Route::post('maketree/cat', ['uses' => 'CategoriesTreeController@updateCategory']);

Route::post('password/email', ['uses' => '\App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::post('password/reset', ['uses' => '\App\Http\Controllers\Auth\ResetPasswordController@reset']);
Route::get('password/reset', ['uses' => '\App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm']);
Route::get('password/reset/{token}', ['uses' => '\App\Http\Controllers\Auth\ResetPasswordController@showResetForm']);

Route::get('/social_login/{provider}', ['as' => 'social.redirect', 'uses' => 'SocialController@login']);
Route::get('/social_login/callback/{provider}', ['uses' => 'SocialController@callback']);


Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['role']], function () {

    Route::get('dashboard', ['uses' => 'HomeController@dashboard']);
    Route::get('', ['uses' => 'HomeController@dashboard']);


    Route::post('logout', ['as' => 'bp.logout', 'uses' => '\Backpack\Base\app\Http\Controllers\Auth\LoginController@logout']);
    Route::get('logout', ['uses' => '\Backpack\Base\app\Http\Controllers\Auth\LoginController@logout']);


    Route::get('import', ['uses' => 'PrsoProductUpdateController@download']);
    Route::get('downloadExcel/{type}', 'PrsoProductUpdateController@downloadExcel');
    Route::post('importExcel', ['as' => 'import', 'uses' => 'PrsoProductUpdateController@importExcel']);
    Route::get('order', ['as' => 'orders', 'uses' => 'OrderController@getOrder']);
    Route::get('order/data', ['as' => 'order.data', 'uses' => 'OrderController@getOrderItems']);
    Route::get('order/data/{id}', ['as' => 'orderitems', 'uses' => 'OrderController@getOrderItemsData']);
    Route::get('order/edit/{id}', ['as' => 'orderedit', 'uses' => 'OrderController@getEditOrder']);
    Route::get('order/delete/{id}', ['as' => 'orderdelete', 'uses' => 'OrderController@getDeleteOrder']);
    Route::match(['get', 'post'], 'order/updatestatus/{id}', ['as' => 'updatestatus', 'uses' => 'OrderController@postEditStatus']);
    Route::match(['get', 'post'], 'order/updateprice/{id}', ['as' => 'updateprice', 'uses' => 'OrderController@postEditPrice']);
    Route::match(['get', 'post'], 'order/updateamount/{id}', ['as' => 'updateamount', 'uses' => 'OrderController@postEditAmount']);


    CRUD::resource('article', 'Admin\ArticleCrudController');
    CRUD::resource('category', 'Admin\CategoryCrudController');
    CRUD::resource('tag', 'Admin\TagCrudController');
    CRUD::resource('user', 'Admin\UserCrudController');
    CRUD::resource('role', 'Admin\RoleCrudController');
    CRUD::resource('product', 'Admin\PrsoProductCrudController');
    CRUD::resource('userattach', 'Admin\UserAttachCrudController');
    CRUD::resource('brands', 'Admin\BrandsCrudController');
    CRUD::resource('models_niss', 'Admin\ModelsNCrudController');
    CRUD::resource('models_infin', 'Admin\ModelsiCrudController');
});
Route::get('help', function () {
    return View('massege');
});
Route::get('nissan', ['as' => 'nissanpop', 'uses' => 'TecDocController@Nissan']);

Route::get('nissan/{groupe}', ['as' => 'nissanpop.groupe', 'uses' => 'TecDocController@NissanPop']);

Route::post('help', '\App\Http\Controllers\UserAttachController@saveAttach');
Route::post('attach', '\App\Http\Controllers\UserAttachController@Attach');

Route::get( 'parser', ['as' => 'parser', 'uses' => 'PrsoProductUpdateController@ParseCategory']);


Route::group(['prefix' => 'cart'], function () {
    Route::get('/', ['as' => 'cart', 'uses' => '\App\Http\Controllers\CartController@getIndex']);
    Route::post('/add', '\App\Http\Controllers\CartController@postAddToCart');
    Route::get('/delete/{id}', ['as' => 'delete_book_from_cart', 'uses' => '\App\Http\Controllers\CartController@getDelete']);
});
Route::group(['prefix' => 'podbor'], function () {
    Route::get('/', ['uses' => 'NissanController@Index']);
    Route::get('{mark}', ['as' => 'nissan', 'uses' => 'NissanController@Mark']);
    Route::get('{mark}/{market}', ['as' => 'nissan.market', 'uses' => 'NissanController@Market']);
    Route::get('{mark}/{market}/{model}', ['as' => 'nissan.market.model', 'uses' => 'NissanController@Model']);
    Route::get('{mark}/{market}/{model}/{modif}', ['as' => 'nissan.market.model.groups', 'uses' => 'NissanController@groups']);
    Route::get('{mark}/{market}/{model}/{modif}/{group}', ['as' => 'nissan.market.model.subgroups', 'uses' => 'NissanController@subgroups']);
    Route::match(['get', 'post'],'{mark}/{market}/{model}/{modif}/{group}/{figure}', ['as' => 'nissan.market.model.groups.illustration', 'uses' => 'NissanController@illustration']);

});


Route::group(['prefix' => 'search'], function () {
    Route::match(['get', 'post'], '/', ['as' => 'search', 'uses' => 'TecDocController@SearchSpares']);
    Route::get('/podbor/{brand}/{number}/{named}', ['as' => 'search.podbor', 'uses' => 'TecDocController@SearchSparesPodbor']);
    Route::match(['get', 'post'], 'vin/', ['as' => 'searchvin', 'uses' => 'NissanController@searchVin']);
    Route::match(['get', 'post'], 'number/', ['as' => 'searchnumber', 'uses' => 'NissanController@searchNumber']);
    Route::match(['get', 'post'], 'nalichie/', ['as' => 'searchprimen', 'uses' => 'TecDocController@Primenimost']);
});

Route::match(['get', 'post'], '/order', ['as' => 'order', 'uses' => '\App\Http\Controllers\OrderController@postOrder']);


//    Route::get('/news/{id}', ['as' => 'News', 'uses' => 'NewsController@getNews']);

Route::get('/news', ['as' => 'AllNews', 'uses' => 'ArticleController@Index']);
Route::get('/news/{id}', ['as' => 'News', 'uses' => 'ArticleController@getNews']);


Route::group(['prefix' => 'nalichie'], function () {
    Route::get('', ['as' => 'nalichie', 'uses' => 'DatatablesController@getIndex']);
    Route::get('/data', ['as' => 'nalichie.data', 'uses' => 'DatatablesController@anyData']);

});


Route::group(['prefix' => 'podbortecdoc'], function () {
    Route::get('', ['as' => 'pegasus', 'uses' => 'PegasusApiController@index']);
    Route::get('/{manuId}', ['as' => 'model', 'uses' => 'PegasusApiController@models']);
    Route::get('/{manuId}/{modId}', ['as' => 'modif', 'uses' => 'PegasusApiController@modifs']);
    Route::get('/{manuId}/{modId}/{carId}', ['as' => 'maintree', 'uses' => 'PegasusApiController@getMainTreeSpares']);
    Route::get('/{manuId}/{modId}/{carId}/{mcatid}', ['as' => 'subtree', 'uses' => 'PegasusApiController@getSubTreeSpares']);
    Route::get('/{manuId}/{modId}/{carId}/{mcatid}/{parentNodeId}', ['as' => 'subtree1', 'uses' => 'PegasusApiController@getSubTreeSpares1']);
    Route::get('/{manuId}/{modId}/{carId}/{mcatid}/{parentNodeId}/{parentNodeId1}', ['as' => 'subtree2', 'uses' => 'PegasusApiController@getSubTreeSpares2']);
});

Route::group(['prefix' => 'pgspares'], function () {
    Route::get('/{manuId}/{modId}/{carId}/{mcatid}/{parentNodeId}/{parentNodeId1}', ['as' => 'pgspares', 'uses' => 'PegasusApiController@getSparesList']);
    Route::get('/{manuId}/{modId}/{carId}/{mcatid}/{parentNodeId}/{parentNodeId1}/{articleId}/{articleLinkId}/{brandName}', ['as' => 'pgsparesinfo', 'uses' => 'PegasusApiController@getSparesListInfoFull']);
    Route::get('/{manuId}/{modId}/{carId}/{mcatid}/{parentNodeId}/{parentNodeId1}/{parentNodeId2}', ['as' => 'pgspares1', 'uses' => 'PegasusApiController@getSparesList1']);
    Route::get('/{manuId}/{modId}/{carId}/{mcatid}/{parentNodeId}/{parentNodeId1}/{parentNodeId2}/{articleId}/{articleLinkId}/{brandName}', ['as' => 'pgsparesinfo1', 'uses' => 'PegasusApiController@getSparesListInfoFull1']);
});


Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^((?!admin).)*$', 'subs' => '.*']);