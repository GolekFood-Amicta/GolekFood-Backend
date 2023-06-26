<?php
use App\Http\Controllers\{
    ListFeedbackController,
    ListNewsController,
    ListSurveyController,
    LoginController,
    LogoutController
};
// use App\Http\Controllers\ListFeedbackController;
// use App\Http\Controllers\ListNewsController;
// use App\Http\Controllers\ListSurveyController;
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


Route::get('/dashboard-admin', function(){
    return view('dashboard');
})->name('dashboard');

Route::resource('/list-feedback', ListFeedbackController::class)->names([
    'index' => 'list-feedback',
]);

Route::resource('/list-news', ListNewsController::class)->names([
    'index' => 'list-news',
]);

Route::resource('/list-survey', ListSurveyController::class)->names([
    'index' => 'list-survey',
]);

Route::get('/list-feedback-search', [ListFeedbackController::class, 'search'])->name('search-feedback');
// iteration