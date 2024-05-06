<?php


$router->get('/', function () use ($router) {
    return $router->app->version();
});


Route::group(['prefix' => 'api'], function ($router) {
    
    Route::get('notes', 'NoteController@notes');
    Route::get('notes/{id}', 'NoteController@getANote');
    Route::post('add-note', 'NoteController@addNote');
    Route::get('user-notes/{id}','NoteController@userNote' );
    Route::post('update-note/{id}', 'NoteController@updateNote');
    Route::post('delete-note/{id}', 'NoteController@deleteNote');
        
    //Route::get('notification/{id}', 'NotificationController@notification');

});