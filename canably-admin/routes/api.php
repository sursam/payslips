<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Api')->group(function(){
    Route::controller(AuthController::class)->as('auth.')->group(function(){
        Route::post('/login', 'login')->name('login');
        Route::post('/register-in-steps', 'registerInStep')->name('register.in.step');
        Route::post('/forget-password', 'getForgetOtp')->name('get.forget.otp');
        Route::post('/reset-password', 'resetPassword')->name('reset.password');
        Route::middleware('auth:api')->group(function(){
            Route::post('/generate-new-token','generateToken')->name('generate.new.token');
            Route::post('/change-password','changePassword')->name('change.password');
            Route::post('/logout','logout')->name('logout');
        });
    });
    Route::controller(AgentController::class)->as('agent.')->prefix('agent')->middleware('auth:api')->group(function(){
        Route::get('/notifications', 'notifications')->name('get.notifications');
        Route::match(['get','post'],'/read-notifications', 'readNotifications')->name('read.notifications');
        Route::post('/delete-notification', 'delteNotification')->name('delete.notifications');
        Route::get('/profile', 'getProfile')->name('get.profile');
        Route::post('/update-profile', 'updateProfile')->name('update.profile');
        Route::post('accept-or-reject','acceptOrReject')->name('accept.or.reject');
        Route::get('deliveries/{status}','deliveries')->name('get.deliveries');
        Route::post('change-delivery-status','changeDeliveryStatus')->name('change.delivery.status');
        Route::get('delivery-details/{uuid}','orderDetails')->name('order.details');
        Route::get('earnings','earnings')->name('earning');
        Route::get('get-bank-details','getBankDetails')->name('get.bank.details');
        Route::post('update-bank-details','updateBankDetails')->name('update.bank.details');
    });
});



