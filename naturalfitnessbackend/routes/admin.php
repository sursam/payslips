<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::namespace('Admin')->as('admin.')->middleware(['auth', 'verified', 'role:super-admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('home')->can('view-dashboard');
        Route::match(['get', 'post'], '/profile', 'profile')->name('profile');
        Route::match(['get', 'post'], '/change-password', 'changePassword')->name('change.password');
    });
    Route::namespace('Cms')->prefix('cms')->as('cms.')->group(function () {
        Route::controller(PagesController::class)->as('page.')->prefix('pages')->group(function () {
            Route::get('/list', 'index')->name('list')->can('view-page');
            Route::match(['get', 'post'], '/add', 'add')->name('add')->can('add-page');
            Route::match(['get', 'post'], '/edit/{uuid}', 'edit')->name('edit')->can('edit-page');
        });
        /*Route::controller(SupportController::class)->as('support.')->prefix('support')->group(function () {
            Route::get('/list', 'index')->name('list');
            Route::match(['get', 'post'], '/add', 'add')->name('add');
            Route::match(['get', 'post'], '/group-add', 'addSupportGroup')->name('group-add');
            Route::match(['get', 'post'], '/edit/{uuid}', 'edit')->name('edit');
            // Route::match(['get', 'post'], '/edit/{uuid}', 'editSupportGroup')->name('edit');
        });
        Route::controller(QueriesController::class)->as('queries.')->prefix('queries')->group(function () {
            Route::get('/list', 'index')->name('list');
            Route::get('/queries-listing/{uuid}', 'queriesListing')->name('queries-listing');
            // Route::get('/queries-details/{uuid}', 'queriesDetails')->name('queries-details');
            Route::match(['get', 'post'], '/add-answer/{uuid}', 'addAnswer')->name('add-answer');
            // Route::match(['get', 'post'], '/group-add', 'addSupportGroup')->name('group-add');
            // Route::match(['get', 'post'], '/edit/{uuid}', 'editSupportGroup')->name('edit');
        });*/
    });
    Route::namespace('User')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::prefix('user')->as('users.')->group(function () {
                Route::get('/list/{userType}', 'index')->name('list');
                Route::match(['get', 'post'], '/{userType}/add', 'add')->name('add');
                Route::match(['get', 'post'], '/{userType}/edit/{uuid}', 'edit')->name('edit');
                Route::match(['get', 'post'], '/{userType}/{uuid}/attach-permissions', 'attachPermissions')->name('attach.permission');
            });
            Route::prefix('customer')->as('customer.')->group(function () {
                Route::get('/list', 'customerList')->name('list');
                Route::get('/view/{uuid}', 'viewCustomer')->name('view');
                // Route::match(['get', 'post'], '/add', 'addCustomer')->name('add');
                // Route::match(['get', 'post'], '/edit/{uuid}', 'editCustomer')->name('edit');
            });
        });

    });
    Route::as('settings.')->prefix('settings')->group(function () {
        Route::namespace('User')->controller(RolePermissionController::class)->group(function () {
            Route::as('role.')->prefix('role')->group(function () {
                Route::get('/', 'roles')->name('list');
                Route::match(['get', 'post'], '/add', 'addRole')->name('add');
                Route::match(['get', 'post'], '/{id}/attach-permissions', 'attachPermissions')->name('attach.permission');
            });
            Route::as('permission.')->prefix('permission')->group(function () {
                Route::get('/', 'permissions')->name('list');
                Route::match(['get', 'post'], '/add', 'addPermission')->name('add');
            });
        });
        Route::controller(SiteSettingController::class)->group(function () {
            Route::match(['get', 'post'], '/site-settings', 'index')->name('site.setting');
        });
        Route::namespace('Zone')->controller(ZoneController::class)->group(function () {
            Route::as('zone.')->prefix('zone')->group(function () {
                Route::get('/', 'index')->name('list');
                Route::match(['get', 'post'], '/add', 'add')->name('add');
                Route::match(['get', 'post'], '/edit/{uuid}', 'edit')->name('edit');
            });
        });
    });
    Route::as('referral.')->prefix('referral')->group(function () {
        Route::namespace('User')->controller(UserController::class)->group(function () {
            Route::get('/list', 'referrals')->name('user.list');
            Route::post('/view/{uuid}', 'viewReferral')->name('user.view');
            Route::match(['get', 'post'], '/add', 'addReferral')->name('user.add');
            Route::match(['get', 'post'], '/edit/{uuid}', 'editReferral')->name('user.edit');
        });
        Route::namespace('Inventory')->as('type.')->prefix('type')->controller(CategoryController::class)->group(function () {
            Route::get('/list', 'referralTypes')->name('list');
            Route::match(['get', 'post'], '/add', 'addReferralType')->name('add');
            Route::match(['get', 'post'], '/edit/{uuid}', 'editReferralType')->name('edit');
        });
    });
    Route::namespace('Fare')->controller(FareController::class)->as('fare.')->prefix('fare')->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::post('/alter', 'alter')->name('alter');
        // Route::match(['get', 'post'], '/add', 'add')->name('add');
        // Route::match(['get', 'post'], '/edit', 'edit')->name('edit');
    });
    Route::namespace('Fare')->controller(HelperFareController::class)->as('helper-fare.')->prefix('helper-fare')->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::post('/alter', 'alter')->name('alter');
    });
    Route::namespace('Support')->prefix('support')->as('support.')->group(function () {
        Route::controller(SupportController::class)->as('type.')->prefix('type')->group(function () {
            Route::get('/list', 'index')->name('list');
            Route::match(['get', 'post'], '/add', 'add')->name('add');
            Route::match(['get', 'post'], '/group-add', 'addSupportGroup')->name('group-add');
            Route::match(['get', 'post'], '/edit/{uuid}', 'edit')->name('edit');
        });
        Route::controller(QueriesController::class)->as('queries.')->prefix('queries')->group(function () {
            Route::get('/list', 'index')->name('list');
            Route::get('/queries-listing/{uuid}', 'queriesListing')->name('queries-listing');
            Route::match(['get', 'post'], '/add-answer/{uuid}', 'addAnswer')->name('add-answer');
        });
        Route::controller(FaqController::class)->as('faq.')->prefix('faq')->group(function () {
            Route::get('/list', 'index')->name('list');
            Route::match(['get', 'post'], '/add', 'add')->name('add');
            Route::match(['get', 'post'], '/edit/{uuid}', 'edit')->name('edit');
            Route::match(['get', 'post'], '/group-add', 'addFaqGroup')->name('group-add');
            Route::match(['get', 'post'], '/group-edit/{uuid}', 'editFaqGroup')->name('group-edit');
        });
    });
    Route::as('medical.')->prefix('medical')->group(function () {
        Route::namespace('Medical')->controller(MedicalController::class)->group(function () {
            Route::prefix('issue')->as('issue.')->group(function () {
                Route::get('/list', 'listIssues')->name('list');
                Route::match(['get', 'post'], '/add', 'addIssue')->name('add');
                Route::match(['get', 'post'], '/edit/{uuid}', 'editIssue')->name('edit');
            });
            Route::prefix('question')->as('question.')->group(function () {
                Route::get('/list', 'listQuestions')->name('list');
                Route::match(['get', 'post'], '/add', 'addQuestion')->name('add');
                Route::match(['get', 'post'], '/edit/{uuid}', 'editQuestion')->name('edit');
            });
        });
        Route::namespace('Inventory')->controller(CategoryController::class)->group(function () {
            Route::prefix('doctor')->as('doctor.')->group(function () {
                Route::get('/level/list', 'listLevels')->name('level.list');
                Route::match(['get', 'post'], '/level/add', 'addLevel')->name('level.add');
                Route::match(['get', 'post'], '/level/edit/{uuid}', 'editLevel')->name('level.edit');
            });
        });
    });
    Route::namespace('User')->as('booking.')->prefix('booking')->group(function () {
        Route::controller(BookingController::class)->group(function () {
            Route::prefix('doctor')->as('doctor.')->group(function () {
                Route::get('/availability/list', 'listDoctorsAvailability')->name('availability.list');
                Route::match(['get', 'post'], '/availability/alter/{uuid}', 'alterDoctorsAvailability')->name('availability.alter');
            });

            Route::get('/list/{status?}', 'index')->name('list');
            Route::match(['get', 'post'], '/add', 'addBooking')->name('add');
            Route::match(['get', 'post'], '/edit/{uuid}', 'editBooking')->name('edit');
            Route::get('/view/{uuid}', 'viewBookingDetails')->name('view');
        });
    });
});
