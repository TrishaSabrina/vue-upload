<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\uploadimage;

use App\Http\Controllers\AuthController;


Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        Route::post('register', 'App\Http\Controllers\AuthController@register');
        // Login User
        Route::post('login', 'App\Http\Controllers\AuthController@login');
        
        // Refresh the JWT Token
        Route::get('refresh', 'App\Http\Controllers\AuthController@refresh');
        
        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user', 'App\Http\Controllers\AuthController@user');
            // Logout user from application
            Route::post('logout', 'App\Http\Controllers\AuthController@logout');
        });

    });

});

Route::get('photo', 'App\Http\Controllers\PhotoController@index');
        
        Route::post('st', 'App\Http\Controllers\PhotoController@store');
        
        Route::get('show/{id}', function ($id) {
            $link = uploadimage::find($id);
            return Response::json($link);
        });
        
        Route::post('update/{id}', 'App\Http\Controllers\PhotoController@update');
        
        Route::post('store_image/delete/{id}', 'App\Http\Controllers\PhotoController@destroy');