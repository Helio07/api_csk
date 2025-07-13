<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\StakeholderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', [UserController::class, 'index']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/dados', [UserController::class, 'show']);
        Route::put('/', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::post('/trocar-senha', [UserController::class, 'trocarSenha']);
    });
    Route::group(['prefix' => 'projeto'], function () {
        Route::get('/', [ProjetoController::class, 'index']);
        Route::post('/', [ProjetoController::class, 'store']);
        Route::put('/{id}', [ProjetoController::class, 'update']);
    });
    Route::group(['prefix' => 'stakeholder'], function () {
        Route::get('/', [StakeholderController::class, 'index']);
        Route::post('/', [StakeholderController::class, 'store']);
        Route::get('/{id}', [StakeholderController::class, 'show']);
        Route::put('/{id}', [StakeholderController::class, 'update']);
        Route::delete('/{id}', [StakeholderController::class, 'destroy']);
    });
});

Route::post('/auth/register', [UserController::class, 'store']);
Route::post('/auth/login', [UserController::class, 'login']);