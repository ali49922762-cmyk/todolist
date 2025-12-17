<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tasks',[TaskController::class,'index']);

Route::get('/tasks/{id}', [TaskController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('add', [TaskController::class, 'store']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/tasks/{id}', [TaskController::class, 'delete']);
});


