<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api'], function ($router) {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('register', 'Auth\AuthController@register');
    Route::post('logout', 'Auth\AuthController@logout');

    // ROUTES WITH AUTH
    Route::group(['middleware' => 'auth:api'], function () {
        //Customers' routes
        Route::get('customers', 'CustomerController@index');
        Route::post('customers', 'CustomerController@store');
        Route::get('customers/{id}', 'CustomerController@show');
        Route::put('customers/{id}', 'CustomerController@update');
        Route::delete('customers/{id}', 'CustomerController@destroy');
        Route::put('customers/name/{id}', 'CustomerController@updateCustomerName');



        //Subscription routes
        Route::get('subscriptions', 'SubscriptionController@index');
        Route::post('subscriptions', 'SubscriptionController@store');
        Route::get('subscriptions/{id}', 'SubscriptionController@show');
        Route::put('subscriptions/{id}', 'SubscriptionController@update');
        Route::delete('subscriptions/{id}', 'SubscriptionController@destroy');
        Route::get('subscriptions/customer/{id}', 'SubscriptionController@subscriptionsByCustomer');
        Route::get('subscriptions/pets/{subscription_id}', 'SubscriptionController@getPetsBySubscription');
        Route::delete('subscriptions/pets/{pet_id}', 'SubscriptionController@destroyPet');
        Route::put('subscriptions/next_order_date/{id}', 'SubscriptionController@updateNextOrderDate');


        //Pets routes
        Route::get('pets', 'PetController@index');
        Route::post('pets', 'PetController@store');
        Route::get('pets/{id}', 'PetController@show');
        Route::put('pets/{id}', 'PetController@update');
        Route::delete('pets/{id}', 'PetController@destroy');


        //Common routes
        Route::post('refresh', 'Auth\AuthController@refresh');
    });
});
