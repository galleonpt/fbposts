<?php

//--  /authenticate
$router->group(['prefix' => 'authenticate'], function () use ($router) {
    $router->post('login', 'AuthController@Login');
    $router->post('register', 'AuthController@Register');
});

//--  /private
$router->group(['prefix' => 'private', 'middleware' => 'auth'], function () use ($router) {
    //USERS
    $router->put('/{id}', "UserController@update");
    $router->delete('/{id}', "UserController@destroy");

    $router->post('/posts', 'PostsController@create');
    $router->delete('/posts/{id}', "PostsController@destroy");
    $router->put('/posts/{id}', "PostsController@update");
    $router->get('/posts', "PostsController@ListUserPosts");

    $router->get('/fb', 'FBController@FbLogin');
});


$router->get('/key', function () {
    return \Illuminate\Support\Str::random(32);
});
