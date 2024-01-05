<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Auth::routes([
    'verify'=> true,
    'login'=>true
]);
Route::namespace('Auth')->controller(LoginController::class)->group(function () {
    Route::get('/admin/login','showAdminLoginForm')->name('admin.login');
    Route::match(['get','post'],'/','showLoginForm')->name('login');
});
Route::namespace('Auth')->controller(RegisterController::class)->group(function () {
    Route::match(['get','post'],'/signup','registration')->name('signup');
});
Route::namespace('Auth')->controller(VerificationController::class)->group(function () {
    Route::get('/email-verification-success','userEmailVerificationSuccess')->name('user.email.verification.success');
});




