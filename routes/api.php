<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\CourseController;
use App\Http\Controllers\Apis\TagController;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
    Route::get('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/courses/{course}', [CourseController::class, 'show']);
    Route::get('/stream/{course}/{lesson}', [CourseController::class, 'stream']);
});
Route::post('login', [AuthController::class, 'login']);
