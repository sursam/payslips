<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes([
    'verify'=>true
]);


Route::get('/', function (){
    return redirect(route('login'));
});
Route::get('/council', function (){
    return redirect(route('council.login'));
});

Route::namespace ('Auth')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::get('/login', 'adminLogin')->name('login');
        });
        Route::controller(ForgotPasswordController::class)->group(function () {
            Route::get('forgot-password','adminForgotPassword')->name('forgot-password');
            Route::post('forgot-password', 'submitAdminForgotPassword')->name('forgot-password.post');
        });
        Route::controller(ResetPasswordController::class)->group(function () {
            Route::get('reset-password/{token}', 'adminResetPassword')->name('reset-password');
            Route::post('reset-password', 'submitAdminResetPassword')->name('reset-password.post');
        });
    });
    Route::as('frontend.')->group(function () {
        Route::controller(RegisterController::class)->group(function(){
            Route::get('create-account','createAccount')->name('create.account');
            Route::get('create-account/{uuid}','createAccount')->name('create.user.account');
            Route::post('create-account','createAccount')->name('create.account');
            Route::match(['get','post'],'delete-account','deleteAccount')->name('delete.account');
        });
    });
    Route::as('council.')->prefix('council')->middleware(['guest'])->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::get('/login', 'councilLogin')->name('login');
        });
        Route::controller(ForgotPasswordController::class)->group(function () {
            Route::get('password/reset','councilForgotPassword')->name('password.request');
            //Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
        });
        /*Route::controller(ResetPasswordController::class)->group(function () {
            Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
            Route::post('password/reset', 'reset')->name('password.update');
        });*/

    });
    Route::as('agent.')->prefix('agent')->middleware(['guest'])->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::get('/login', 'agentLogin')->name('login');
        });
        Route::controller(ForgotPasswordController::class)->group(function () {
            Route::get('password/reset','agentForgotPassword')->name('password.request');
        });

    });
});
