<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::get('demo', 'TodoController@demo');


Route::group(['prefix' => 'api'], function ($router) {
    
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth'], function ($router) {
        Route::post('profile', 'AuthController@me');
        Route::post('logout', 'AuthController@logout');

        Route::post('delete-note/{id}', 'NoteController@deleteNote');
        Route::get('user-notes/{id}','NoteController@userNote' );
        Route::get('notes', 'NoteController@notes');
        Route::post('add-note', 'NoteController@addNote');
        Route::post('update-note/{id}', 'NoteController@updateNote');
        Route::get('notes/{id}', 'NoteController@getANote');
        
        Route::get('notification/{id}', 'NotificationController@notification');
    });
    
    
    // Route::delete('delete-note/{id}', 'NoteController@deleteNote');
    
});