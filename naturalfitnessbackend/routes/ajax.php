<?php

use App\Http\Controllers\Ajax\CustomerAjaxController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ajax routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "ajax" middleware group. Make something great!
|
*/
Route::namespace('Ajax')->as('ajax.')->prefix('ajax')->group(function () {
    Route::middleware(['auth'/*,'verified'*/])->group(function(){
        Route::controller(AjaxController::class)->middleware(['role:super-admin'])->group(function () {
            Route::group(['as' => 'get.'], function () {
                Route::get('/getUsers/{role?}', 'getUsers')->name('users');
                Route::get('/getUser/{uuid}', 'getUser')->name('user');
                Route::get('/getPages', 'getPages')->name('pages');
                Route::get('/getFares', 'getFares')->name('fares');
                Route::get('/getHelperFares', 'getHelperFares')->name('helper-fares');
                Route::get('/getRoles', 'getRoles')->name('roles');
                Route::get('/getCategories', 'getCategories')->name('categories');
                Route::get('/getQuestions', 'getQuestions')->name('get.questions');
                Route::get('/getCompanies', 'getCompanies')->name('companies');
                Route::get('/getZones', 'getZones')->name('zones');
                Route::get('/getMemberships', 'getMemberships')->name('memberships');
                Route::get('/getVehicles', 'getVehicles')->name('vehicles');
                Route::get('/getVehicleTypes/{uuid?}', 'getVehicleTypes')->name('vehicle.types');
                Route::get('/getVehicleBodyTypes/{uuid?}', 'getVehicleBodyTypes')->name('vehicle.body.types');
                Route::get('/getVehicleSubTypes', 'getVehicleSubTypes')->name('vehicle.subtypes');
                Route::get('/getVehicleCompanies', 'getVehicleCompanies')->name('vehicle.companies');
                Route::get('/getWalletTransactions', 'getWalletTransactions')->name('wallet.transactions');
                Route::get('/getUsersByConditions', 'getUsersByConditions')->name('get.users.conditions');
                Route::get('/getDeletedUsersByConditions', 'getDeletedUsersByConditions')->name('get.users.deleted');
                Route::get('/getBookings/{status?}', 'getBookings')->name('get.bookings');
                Route::get('/getReferrals', 'getReferrals')->name('get.referrals');
                Route::get('/getIssues', 'getIssues')->name('get.issues');
                Route::get('/getDoctorAvailabilities', 'getDoctorAvailabilities')->name('get.doctor.availabilities');
                Route::get('/getAvailableSlots', 'getAvailableSlots')->name('get.availableSlots');

            });
            Route::group(['as' => 'update.'], function () {
                Route::match(['put', 'post'], '/updateStatus', 'setStatus')->name('status');
                Route::match(['put', 'post'], '/updateBrandingStatus', 'setBrandingStatus')->name('branding.status');
                Route::put('/pitchAction', 'pitchAction')->name('pitch.action');
                // Route::match(['put', 'post'], '/update/settings', 'updateSettings')->name('settings');
                Route::match(['put', 'post'], '/updateMediaStatus', 'updateMediaStatus')->name('media.status');
                Route::patch('/fcm-token', 'updateToken')->name('fcmToken');
            });
            Route::group(['as' => 'delete.'], function () {
                Route::delete('/deleteData', 'deleteData')->name('data');
                Route::delete('/deleteTableData', 'deleteTableData')->name('table.data');
            });
        });
        Route::controller(AjaxController::class)->middleware(['role:council'])->group(function () {
            Route::group(['as' => 'delete.'], function () {
                Route::delete('/deleteCouncilData', 'deleteCouncilData')->name('data');
            });
        });
        Route::controller(AjaxController::class)->as('get.')->group(function () {
            Route::get('/get-cities-by-state/{slug}', 'getCitiesByState')->name('cities.by.state');
        });
    });
});
