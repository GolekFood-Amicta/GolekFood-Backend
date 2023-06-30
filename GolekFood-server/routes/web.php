<?php
use App\Http\Controllers\{
    ChangePasswordController,
    DashboardController,
    ListFeedbackController,
    ListNewsController,
    ListSurveyController,
    ListUserSubs,
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

//usersubs
Route::resource('/list-usersubs', ListUserSubs::class)->names([
    'index' => 'list-usersubs',
    // 'update' => 'update-usersubs',
]);
//antrean
Route::get('/list-queuesubs', [ListUserSubs::class, 'indexAntrean'])->name('list-queuesubs');


//user
Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password');


//upgrade roles user
// Route::get('/upgrade-role', [UserProfileController::class, 'upgradeRole'])->name('upgrade-role');