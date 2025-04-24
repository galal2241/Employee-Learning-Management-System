<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\QuizController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::post('/', [CourseController::class, 'store']);
        Route::get('/{id}', [CourseController::class, 'show']);
        Route::put('/{id}', [CourseController::class, 'update']);
        Route::delete('/{id}', [CourseController::class, 'destroy']);
    });

    Route::prefix('courses/{courseId}/lessons')->group(function () {

        Route::prefix('quizzes')->group(function () {
            Route::get('/', [QuizController::class, 'index']);
            Route::post('/', [QuizController::class, 'store']);
            Route::get('/{id}', [QuizController::class, 'show']);
            Route::put('/{id}', [QuizController::class, 'update']);
            Route::delete('/{id}', [QuizController::class, 'destroy']);
        });
    
        Route::get('/', [LessonController::class, 'index']);
        Route::post('/', [LessonController::class, 'store']);
        Route::get('/{id}', [LessonController::class, 'show']);
        Route::put('/{id}', [LessonController::class, 'update']);
        Route::delete('/{id}', [LessonController::class, 'destroy']);
    });
});
