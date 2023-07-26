<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserSubsController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\SurveyResultController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\GoogleAPIController;
use App\Http\Controllers\SubscriptionNewsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword']);
Route::get('/reset-password/{token}', [AuthenticationController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password-client', [AuthenticationController::class, 'resetPasswordClient']);


//User
Route::controller(UserController::class)->group(function(){
    Route::prefix('/user')->group(function (){
        Route::get('/', 'getUser');
        Route::get('/{id}', 'getUser');
        Route::put('/', 'updateUser')->middleware(['auth:sanctum']);
        Route::delete('/', 'deleteUser');
    });
});

//User with google
Route::get('/auth/google', [GoogleAPIController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleAPIController::class, 'handleGoogleCallback']);

Route::group(['middleware' => ['web']], function () {
    Route::get('/auth/google', [GoogleAPIController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleAPIController::class, 'handleGoogleCallback']);
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

//Survey Result
Route::controller(SurveyResultController::class)->group(function(){
    Route::prefix('/survey-result')->group(function (){
        Route::get('/', 'getSurveyResult');
        Route::post('/', 'addSurveyResult');
        Route::delete('/', 'deleteSurveyResult');
    });
});


//User Subs
Route::controller(UserSubsController::class)->group(function(){
    Route::prefix('/user-subs')->group(function (){
        Route::get('/', 'getUserSubs');
        Route::get('/{id}', 'getUserSubs');
    });

    Route::prefix('/request-subscription')->group(function(){
        Route::post('/', 'requestUserSubs');
    });

    Route::prefix('/approve-subscription')->group(function(){
        Route::put('/', 'approveUserSubs');
    });
    
    Route::prefix('/decline-subscription')->group(function(){
        Route::post('/', 'declineUserSubs');
    });


});

//Subscription News
Route::controller(SubscriptionNewsController::class)->group(function(){
    Route::prefix('/subscription-news')->group(function (){
        Route::post('/', 'addSubscriptionNews');
    });
});

//Discover Food
Route::post('/discover-food-adv', [FavouriteController::class, 'discoverFoodAdv'])->middleware('auth:sanctum');




