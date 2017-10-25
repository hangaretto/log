<?php

Route::group(['prefix' => 'api/v1/magnetar/log'], function () {

    Route::group(['middleware' => [config('magnetar.log.middleware.auth')]], function () {

        Route::group(['prefix' => 'logs'], function () {

            Route::group(['middleware' => [config('magnetar.log.middleware.super_admin')]], function () {

                Route::get('/', 'Magnetar\Log\Controllers\LogController@index');
                Route::post('/', 'Magnetar\Log\Controllers\LogController@process');
                Route::get('/{id}', 'Magnetar\Log\Controllers\LogController@show')->where('id', '[0-9]+');
                Route::put('/{id}', 'Magnetar\Log\Controllers\LogController@process')->where('id', '[0-9]+');
                Route::delete('/{id}', 'Magnetar\Log\Controllers\LogController@destroy')->where('id', '[0-9]+');

            });

        });

    });

});
