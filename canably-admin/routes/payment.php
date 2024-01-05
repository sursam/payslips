<?php

use Illuminate\Support\Facades\Route;

Route::controller(PaymentController::class)->as('payment.')->middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::match(['get','post'],'/checkout', 'checkout')->name('checkout');
    Route::match(['get', 'post'], '/details', 'paymentDetails')->name('details');
    Route::match(['get', 'post'], '/success', 'paymentSucces')->name('success');
});
