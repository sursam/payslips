<?php

use Illuminate\Support\Facades\Route;

Route::controller(CustomerController::class)->as('customer.')->middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/wishlist', 'wishList')->name('wish.list');
    Route::get('/settings', 'settings')->name('settings');
    Route::match(['get','post'],'/cart', 'cart')->name('cart');
    Route::get('/orders', 'orders')->name('order.list');
    Route::get('/order-details/{uuid}', 'orderDetails')->name('order.details');
    //Route::get('/checkout', 'checkout')->name('checkout');
    Route:: as ('address.book.')->group(function () {
        Route::get('/address-book', 'addressBook')->name('index');
    });
    Route::post('/update-profile-image','updateProfileImage')->name('update.profile.image');
    Route:: as ('update.')->group(function () {
        Route::post('/update-profile', 'updateProfile')->name('profile');
    });
    Route:: as ('change.')->group(function () {
        Route::post('/change-password', 'changePassword')->name('password');
    });

});
