<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/list-user', [UserController::class,'index']);

Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/logout', [AuthenticationController::class, 'logout'])->middleware(['auth:sanctum']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/change-password', [AuthenticationController::class, 'changePassword'])->middleware(['auth:sanctum']);

//feedback
Route::controller(FeedbackController::class)->group(function () {
    Route::prefix('/feedback')->group(function () {
        Route::get('/', 'getFeedback');
        Route::get('/{id}', 'getFeedback');
        Route::post('/', 'addFeedback');
        Route::put('/', 'updateFeedback');
        Route::delete('/', 'deleteFeedback');
    });

    Route::prefix('/feedback-user')->group(function () {
        Route::get('/{id}', 'getFeedbackByIdUser');
    });

});
