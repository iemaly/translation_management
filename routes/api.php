<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TranslationController;


Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('/translation', TranslationController::class)->except('show');
        Route::get('/translation/search', [TranslationController::class, 'search']);
        Route::get('/translation/export', [TranslationController::class, 'export']);
    });
});
