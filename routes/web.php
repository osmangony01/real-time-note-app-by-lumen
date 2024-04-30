<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('todos', 'TodoController@todos');
$router->post('add-todo', 'TodoController@addTodo');
$router->get('todos/{id}', 'TodoController@getATodo');
$router->post('update-todo/{id}', 'TodoController@updateTodo');
$router->delete('delete-todo/{id}', 'TodoController@deleteTodo');


Route::get('demo', 'TodoController@demo');


Route::group(['prefix' => 'api'], function ($router) {
    
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth'], function ($router) {
        Route::post('profile', 'AuthController@me');
        Route::post('logout', 'AuthController@logout');
    });

});