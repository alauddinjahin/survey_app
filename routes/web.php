<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;


Auth::routes();


Route::redirect('/home', '/');
Route::resource('/', FrontendController::class);
Route::get('/show/{id}',  [FrontendController::class,'show'])->name('frontend_show');
Route::get('/embed', [FrontendController::class,'embed_survey'])->name('embed_survey');
Route::resource('answers', AnswerController::class);

Route::redirect('/admin', '/dashboard');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth','authorize']],function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('surveys', SurveyController::class);
    Route::post('questions-order', [SurveyController::class,'updateQuestionsOrder'])->name('updateQuestionsOrder');

    Route::resource('questions', QuestionController::class);
    Route::resource('payments', PaymentController::class);

    //users 
    Route::post('/user-status',         [Pondit\Authorize\Controllers\UsersController::class, 'updateUserStatus'])->name('users.updateUserStatus');
    Route::get('/user-profile',         [Pondit\Authorize\Controllers\UsersController::class, 'loadAuthUserProfile'])->name('users.loadAuthUserProfile');
    Route::post('/user-create',         [Pondit\Authorize\Controllers\UsersController::class, 'create_new_user'])->name('users.create_new_user');

});

