<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Frontend')->as('frontend.')->controller(FrontendController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::match(['get', 'post'], 'product/cart', 'cart')->name('cart');
    Route::get('/list/{type}', 'listBy')->name('list.by');
    Route::match(['get', 'post'], '/shop-by-type/{type?}/{value?}', 'shopByType')->name('shop.by.type');
    Route::get('/shop-by-category/{slug?}', 'shopByCategory')->name('shop.by.category');
    Route::match(['get', 'post', 'put'], '/product/{uuid}', 'productDetails')->name('product.details');
    Route::get('/blogs', 'blogs')->name('blogs');
    Route::get('/blogs-details/{uuid}', 'blogDetails')->name('blogs.details');

    Route::post('/add-driver', 'addDriver')->name('add.driver');
});
