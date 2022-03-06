<?php

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@store');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('logout', 'API\AuthController@logout');
    Route::group(['prefix' => 'user'], function(){
        Route::get('me', 'API\AuthController@show');
        Route::post('update', 'API\AuthController@update');
    });
});

Route::group(['middleware' => ['web']], function () {
    Route::get('login/{driver}', 'API\SocialController@redirectToProvider');
    Route::get('login/{driver}/callback', 'API\SocialController@handleProviderCallback');
});
