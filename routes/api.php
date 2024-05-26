<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/getPageAll', [\App\Http\Controllers\Api\UserController::class, 'getPageAll']);
        Route::get('/getAll', [\App\Http\Controllers\Api\UserController::class, 'getAll']);
        Route::get('/getById', [\App\Http\Controllers\Api\UserController::class, 'getById']);
        // Route::get('/getById/{user_id}', [\App\Http\Controllers\Api\UserController::class, 'getById'])->whereNumber('user_id');
        Route::post('/create', [\App\Http\Controllers\Api\UserController::class, 'create']);
        Route::put('/update', [\App\Http\Controllers\Api\UserController::class, 'update']);
        Route::delete('/delete', [\App\Http\Controllers\Api\UserController::class, 'delete']);
        Route::get('/getProfile', [\App\Http\Controllers\Api\UserController::class, 'getProfile']);
    });
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
