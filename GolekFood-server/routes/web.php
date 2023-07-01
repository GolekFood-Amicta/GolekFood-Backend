<?php
use App\Http\Controllers\{
    ChangePasswordController,
    DashboardController,
    ListFeedbackController,
    ListNewsController,
    ListSurveyController,
    ListUserSubs,
    ListFavouriteController,
    ListUserController,
    LoginController,
    LogoutController,
    UserProfileController
};

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-admin', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/login-admin', [LoginController::class,'authenticate'])->name('post-login');

Route::post('/logout-admin', [LogoutController::class,'logout'])->name('logout');


Route::get('/dashboard-admin', [DashboardController::class, 'index'])->name('dashboard');

//feedback
Route::resource('/list-feedback', ListFeedbackController::class)->names([
    'index' => 'list-feedback',
]);

Route::get('/list-feedback-search', [ListFeedbackController::class, 'search'])->name('search-feedback');

//news
Route::resource('/list-news', ListNewsController::class)->names([
    'index' => 'list-news',
    'create' => 'create-news',
   
]);
Route::get('/list-news-search', [ListNewsController::class, 'search'])->name('search-news');

//survey
Route::resource('/list-survey', ListSurveyController::class)->names([
    'index' => 'list-survey',
]);

//favourite
Route::resource('list-favourite', ListFavouriteController::class)->names([
    'index' => 'list-favourite',
]);

Route::get('/list-favourite-search', [ListFavouriteController::class, 'search'])->name('search-favourite');

//user
Route::resource('/list-user', ListUserController::class)->names([
    'index' => 'list-user',
]);

Route::get('/list-user-search', [ListUserController::class, 'search'])->name('search-user');

//usersubs
Route::resource('/list-usersubs', ListUserSubs::class)->names([
    'index' => 'list-usersubs',
    // 'update' => 'update-usersubs',
]);

//antrean
Route::get('/list-queuesubs', [ListUserSubs::class, 'indexAntrean'])->name('list-queuesubs');

//user
Route::resource('/profile', UserProfileController::class)->names([
    'index' => 'profile',
]);

Route::resource('/change-password', ChangePasswordController::class)->names([
    'index' => 'change-password',
]);

//upgrade roles user
// Route::get('/upgrade-role', [UserProfileController::class, 'upgradeRole'])->name('upgrade-role');