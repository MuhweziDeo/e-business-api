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
    Route::post('password-reset/request','Auth\ResetPasswordController@reset_password_request');
    Route::put('password-reset/confirm','Auth\ResetPasswordController@reset_password_confirm');
    Route::put('confirmation', 'Auth\VerificationController@confirmEmail');

    // Profile
    Route::put('profiles/{uuid}', 'Profile\ProfileController@update');
    Route::get('profiles/{uuid}', 'Profile\ProfileController@show');
    Route::get('profiles', 'Profile\ProfileController@index');


    //Resources
    Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);

    Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);

    Route::resource('products', 'Product\ProductController');

    Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show',
        'store', 'update', 'destroy']]);

    Route::resource('categories', 'Category\CategoryController', ['only' => ['store', 'edit', 'index']]);

    Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);



});


