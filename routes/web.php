<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$router->get('/', function () use ($router) {
    return $router->app->version();
});


Route::group(['prefix' => 'api'], function ($router) {
    
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth'], function ($router) {
        Route::post('profile', 'AuthController@me');
        Route::post('logout', 'AuthController@logout');
    });
    
});