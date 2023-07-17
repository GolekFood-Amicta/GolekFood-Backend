<?php
use App\Http\Controllers\{
    ChangePasswordController,
    DashboardController,
    ListFeedbackController,
    ListNewsController,
    ListSurveyController,
    ListUserSubs,
    ListFavouriteController,
    ListSubscriptionNewsController,
    ListUserController,
    LoginController,
    LogoutController,
    SubscriptionNewsController,
    TestingEmailController,
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
    if(auth()->user()){
        return redirect()->route('dashboard');
    }else{
        return redirect()->route('login');
    }
});

Route::get('/login-admin', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/login-admin', [LoginController::class,'authenticate'])->name('post-login')->middleware('guest');
Route::post('/logout-admin', [LogoutController::class,'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard-admin', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/email/verification-notification', [DashboardController::class, 'verifEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('/email/verify/{id}/{hash}', [DashboardController::class, 'sendVerifEmail'])->middleware(['auth', 'signed'])->name('verification.verify');


//feedback
Route::resource('/list-feedback', ListFeedbackController::class)->names([
    'index' => 'list-feedback',
])->middleware('auth');

Route::get('/list-feedback-search', [ListFeedbackController::class, 'search'])->name('search-feedback')->middleware('auth');

//news
Route::resource('/list-news', ListNewsController::class)->names([
    'index' => 'list-news',
    'create' => 'create-news',
])->middleware('auth');

Route::get('/list-news-search', [ListNewsController::class, 'search'])->name('search-news')->middleware('auth');

//survey
Route::resource('/list-survey', ListSurveyController::class)->names([
    'index' => 'list-survey',
])->middleware('auth');

//favourite
Route::resource('list-favourite', ListFavouriteController::class)->names([
    'index' => 'list-favourite',
])->middleware('auth');

Route::get('/list-favourite-search', [ListFavouriteController::class, 'search'])->name('search-favourite')->middleware('auth');

//user
Route::resource('/list-user', ListUserController::class)->names([
    'index' => 'list-user',
])->middleware('auth');

Route::get('/list-user-search', [ListUserController::class, 'search'])->name('search-user')->middleware('auth');

//usersubs
Route::resource('/list-usersubs', ListUserSubs::class)->names([
    'index' => 'list-usersubs',
    // 'update' => 'update-usersubs',
])->middleware('auth');

//antrean
Route::get('/list-queuesubs', [ListUserSubs::class, 'indexAntrean'])->name('list-queuesubs')->middleware('auth');

//user
Route::resource('/profile', UserProfileController::class)->names([
    'index' => 'profile',
])->middleware('auth');

Route::resource('/change-password', ChangePasswordController::class)->names([
    'index' => 'change-password',
])->middleware('auth');

//upgrade roles user
// Route::get('/upgrade-role', [UserProfileController::class, 'upgradeRole'])->name('upgrade-role');

//Langganan News
Route::resource('/langganan-news', ListSubscriptionNewsController::class)->names([
    'index' => 'list-langganan-news',
    'create' => 'create-langganan-news',
    'store' => 'store-langganan-news',
])->middleware('auth');


Route::get('/langganan-news-search', [ListSubscriptionNewsController::class, 'search'])->name('search-langganan-news')->middleware('auth');
Route::get('/send-email', [TestingEmailController::class, 'index']);
