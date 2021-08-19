<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('logout', function () {
     \auth()->logout();
    return redirect('/');
})->name('logout');
Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::namespace('Preorder')->group(function () {
        Route::get('/', 'MainController@index')->name('main.index');
        Route::post('/', 'MainController@filter')->name('main.filter');
        Route::get('/create', 'CreateController@index')->name('create.index');
        Route::post('/create', 'CreateController@store')->name('create.store');
        Route::get('/edit/{id}', 'EditController@index')->name('edit.index');
        Route::post('/edit/{id}', 'EditController@update')->name('edit.store');
        Route::get('/vote', 'RatingController')->name('rating.vote');
        Route::get('/comment', 'CommentController')->name('comment');
        Route::get('/reserve', 'ReserveController')->name('reserve');
        Route::get('/success', 'OrderController@success')->name('order.reserve');
        Route::get('/denied', 'OrderController@denied')->name('order.reserve');

        Route::get('/getcatbygroup', 'CreateController@getCatByGroup')->name('create.cat');
    });
});

Route::group(['middleware' => 'admin'], function () {
    Route::namespace('Preorder\admin')->prefix('admin')->group(function () {
        Route::get('/', 'SetupController@index')->name('admin.index');
        Route::post('/', 'SetupController@test')->name('admin.test');


        Route::get('/selfpricevalue', 'SelfPriceController@getSelfPriceValue');
        Route::post('/selfpricestore', 'SelfPriceController@store')->name('selfprice.store');

        Route::get('/sellpricevalue', 'SellPriceController@getSellPriceValue');
        Route::post('/sellpricestore', 'SellPriceController@store')->name('sellprice.store');

        Route::get('deliverytimevalue', 'DeliveryTimeController@getValue');
        Route::post('deliverytimestore', 'DeliveryTimeController@store')->name('delivery_time.store');

        Route::get('showsellpricetable', 'SellPriceController@showall')->name('sellprice.table');
        Route::get('showselfpricetable', 'SelfPriceController@showall')->name('selfprice.table');
        Route::get('showsdeliverytable', 'DeliveryTimeController@showall')->name('delivery.table');


    });

    Route::get('/test', 'Test');
});
