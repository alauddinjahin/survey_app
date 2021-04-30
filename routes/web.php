<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;


Auth::routes();


Route::resource('/', FrontendController::class);

Route::redirect('/admin', '/dashboard');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth','authorize']],function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('surveys', SurveyController::class);
    Route::resource('questions', QuestionController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('answers', AnswerController::class);

    //users 
    Route::post('/user-status',         [Pondit\Authorize\Controllers\UsersController::class, 'updateUserStatus'])->name('users.updateUserStatus');
    Route::get('/user-profile',         [Pondit\Authorize\Controllers\UsersController::class, 'loadAuthUserProfile'])->name('users.loadAuthUserProfile');
    Route::post('/user-create',         [Pondit\Authorize\Controllers\UsersController::class, 'create_new_user'])->name('users.create_new_user');

});

