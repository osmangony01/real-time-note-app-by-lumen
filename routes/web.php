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

        Route::get('notes', 'NoteController@notes');
        Route::post('add-note', 'NoteController@addNote');
        Route::get('user-notes/{id}','NoteController@userNote' );
        Route::post('update-note/{id}', 'NoteController@updateNote');
        Route::get('notes/{id}', 'NoteController@getANote');
        Route::post('delete-note/{id}', 'NoteController@deleteNote');
        
        Route::get('notification/{id}', 'NotificationController@notification');

    });
});


// Route::group(['prefix' => 'api'], function ($router) {
    
//     Route::post('register', 'AuthController@register');
//     Route::post('login', 'AuthController@login');

//     Route::group(['middleware' => 'auth'], function ($router) {
//         Route::post('profile', 'AuthController@me');
//         Route::post('logout', 'AuthController@logout');
//     });
    
// });