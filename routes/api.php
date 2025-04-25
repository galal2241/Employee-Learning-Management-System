<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\ProgressController;
use App\Http\Controllers\API\QuestionController; // أضف الـ use statement ده
use App\Http\Controllers\API\QuizSystemController;

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
            Route::prefix('{quizId}/questions')->group(function () { 
                Route::get('/', [QuestionController::class, 'index']);
                Route::post('/', [QuestionController::class, 'store']);
                Route::get('/{id}', [QuestionController::class, 'show']);
                Route::put('/{id}', [QuestionController::class, 'update']);
                Route::delete('/{id}', [QuestionController::class, 'destroy']);
            });

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

    Route::post('{quizId}/submit', [QuizSystemController::class, 'submitQuiz']);
    Route::get('{quizId}/results', [QuizSystemController::class, 'getResults']);
});
    Route::prefix('courses/{courseId}/progress')->group(function () {
        Route::post('lessons/{lessonId}/complete', [ProgressController::class, 'completeLesson']);
        Route::get('/', [ProgressController::class, 'getProgress']);

        Route::get('/certificate/{employeeId}/{courseId}', [App\Http\Controllers\CertificateController::class, 'generate'])->name('certificate.generate');
    });
