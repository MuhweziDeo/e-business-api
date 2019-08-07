<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1'], function() {
    //Auth
    Route::post('login', 'Auth\LoginController@login');
    Route::post('me', 'Auth\LoginController@me');
    Route::post('logout', 'Auth\LoginController@logout');

    // Profile
    Route::put('profiles/{uuid}', 'Profile\ProfileController@update');
    Route::get('profiles/{uuid}', 'Profile\ProfileController@show');
    Route::get('profiles', 'Profile\ProfileController@index');


    Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);

    Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);

    Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);

    Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

    Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

    Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);

    Route::put('confirmation', 'Auth\VerificationController@confirmEmail');

});


