<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::as('api.')->group(function () {
    Route::namespace('Api')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login')->name('login');
            Route::post('verify-otp', 'verifyOtp')->name('otp.verify');
        });
        Route::middleware('auth:api')->group(function () {
            Route::controller(AuthController::class)->group(function () {
                Route::get('logout', 'logout')->name('logout');
            });
        });
    });
    Route::namespace('Api\Common')->group(function () {
        Route::controller(SupportController::class)->group(function () {
            Route::get('get-support-types', 'getSupportTypes')->name('support.types.get');
            // Route::post('support-add', 'add')->name('support-add');
            Route::get('faq-list', 'getFaqs')->name('faq.list');
            Route::middleware('auth:api')->group(function () {
                Route::post('add-support', 'add')->name('support.add');
                Route::post('add-support-answer', 'addSupportAnswer')->name('support.answer.add');
                Route::get('user-support-list', 'getUserSupportList')->name('user.support.list');
                Route::get('user-support-answer-list/{uuid}', 'getQuaryAnswer')->name('user.support.answer.list');
                Route::get('women-safety-request', 'womenSafetyRequest')->name('women.safety.request');
            });
        });
        Route::controller(CommonController::class)->group(function () {
            Route::middleware('auth:api')->group(function () {
                Route::get('get-vehicle-types', 'getVehicleTypes')->name('vehicle.type');
                Route::get('get-payment-modes', 'getPaymentModes')->name('get.payment.modes');
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Customer API Routes Starts
    |--------------------------------------------------------------------------
    */
    Route::namespace('Api\Customer')->prefix('customer')->as('customer.')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login')->name('login');
            Route::post('verify-otp', 'verifyOtp')->name('otp.verify');
        });
        Route::middleware('auth:api')->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('get-details', 'getCustomerDetails')->name('details.get');
                Route::post('update-details', 'updateCustomerDetails')->name('details.update');
                Route::get('list-addresses', 'listCustomerAddresses')->name('address.list');
                Route::post('add-address', 'addUpdateCustomerAddress')->name('address.add');
                Route::post('update-address', 'addUpdateCustomerAddress')->name('address.update');
            });
            Route::controller(BookingController::class)->group(function () {
                Route::post('calculate-fare', 'calculateFare')->name('calculate.fare');
                Route::post('book-ride', 'bookRide')->name('ride.book');
            });
        });
    });
    /*
    |--------------------------------------------------------------------------
    | Customer API Routes Ends
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Driver API Routes Starts
    |--------------------------------------------------------------------------
    */
    Route::namespace('Api\Driver')->prefix('driver')->as('driver.')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login')->name('login');
            Route::post('verify-otp', 'verifyDriverOtp')->name('otp.driver.verify');
        });

        Route::middleware('auth:api')->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('get-details', 'getDriverDetails')->name('details.get');
                Route::post('update-details', 'updateDriverDetails')->name('details.update');
                Route::get('profile-info', 'getDriverProfileInfo')->name('profile.info');
                Route::post('update-profile', 'updateDriverProfileInfo')->name('profile.update');
                Route::post('recharge-wallet', 'rechargeWallet')->name('wallet.recharge');
                Route::get('wallet-info', 'getWalletInfo')->name('wallet.info');
                Route::post('apply-branding', 'applyForBranding')->name('branding.apply');
                Route::get('get-branding-help-text', 'getBrandingHelpText')->name('branding.help.text.get');
                Route::get('get-notifications', 'getNotifications')->name('notifications.get');
                Route::post('delete-account', 'deleteAccount')->name('account.delete');
                Route::post('set-online-status', 'setOnlineStatus')->name('online.status.set');
            });
            Route::controller(VehicleController::class)->group(function () {
                Route::get('get-vehicle-companies', 'getVehicleCompanies')->name('vehicle.companies');
                //Route::post('add-vehicle', 'addVehicle')->name('vehicle.add');
                Route::get('get-vehicle-info', 'getVehicleInfo')->name('vehicle.info');
            });
            Route::controller(BookingController::class)->group(function () {
                Route::post('get-bookings', 'getBookings')->name('get.bookings');
                Route::post('set-booking-status', 'setBookingStatus')->name('set.booking.status');
            });
        });
    });
    /*
    |--------------------------------------------------------------------------
    | Driver API Routes Ends
    |--------------------------------------------------------------------------
    */

});
