<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Models\Favourite;
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

Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/logout', [AuthenticationController::class, 'logout'])->middleware(['auth:sanctum']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/change-password', [AuthenticationController::class, 'changePassword'])->middleware(['auth:sanctum']);

//User
Route::controller(UserController::class)->group(function(){
    Route::prefix('/user')->group(function (){
        Route::get('/', 'getUser');
        Route::get('/{id}', 'getUser');
        Route::put('/', 'updateUser');
        Route::delete('/', 'deleteUser');
    });
});


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


//News
Route::controller(NewsController::class)->group(function () {
    Route::prefix('/news')->group(function () {
        Route::get('/', 'getNews');
        Route::get('/{id}', 'getNews');
        Route::post('/', 'addNews');
        Route::delete('/', 'deleteNews');
        Route::post('/{id}', 'updateNews');
    });

    Route::prefix('/news-user')->group(function (){
        Route::get('/{id}', 'getNewsByIdUser');
    });
});

//Favourite
Route::controller(FavouriteController::class)->group(function(){
    Route::prefix('/favourite')->group(function (){
        Route::get('/', 'getFavourite');
        Route::get('/{id}', 'getFavourite');
        Route::post('/', 'addFavourite');
        Route::put('/', 'updateFavourite');
        Route::delete('/', 'deleteFavourite');
    });

    Route::prefix('/favourite-user')->group(function(){
        Route::get('/{id}', 'getFavouriteByIdUser');
    });
});

//Discover Food
Route::post('/discover-food', [FavouriteController::class, 'discoverFood']);
Route::post('/discover-food-adv', [FavouriteController::class, 'discoverFoodAdv']);


