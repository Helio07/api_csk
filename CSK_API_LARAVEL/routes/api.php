<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjetoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    Route::group(['prefix' => 'projeto'], function () {
        Route::get('/', [ProjetoController::class, 'index']);
        Route::post('/', [ProjetoController::class, 'store']);
        Route::post('/update', [ProjetoController::class, 'update']);
    });
});

Route::post('/auth/register', [UserController::class, 'store']);
Route::post('/auth/login', [UserController::class, 'login']);