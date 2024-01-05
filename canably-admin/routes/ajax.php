<?php


use Illuminate\Support\Facades\Route;


Route::namespace('Admin')->controller(AjaxController::class)->as('ajax.')->middleware(['auth','verified','role:super-admin|admin|sub-admin|customer'])->group(function () {
    Route::get('/getRoles', 'getRoles')->name('get.roles');
    Route::get('/getPermissions', 'getPermissions')->name('get.permissions');
    Route::get('/getSubCategories', 'getSubCategories')->name('get.sub.categories');
    Route::get('/getCountries', 'getCountries')->name('get.countries');
    Route::get('/getProductImages/{uuid}', 'getProductImages')->name('get.product.images');
    Route::post('/makeFeaturedImage', 'makeFeaturedImage')->name('make.featured.image');

    route::post('/get-shipping-cost','getShippingCost')->name('get.shipiing.cost');
    Route::post('/category-wise-product', 'categoryWiseProduct')->name('category.wise.product');

    Route::group(['as'  => 'add.'], function() {
        Route::post('/addCosts', 'addCosts')->name('costs');
    });
    Route::group(['as'  => 'update.'], function() {
        Route::match(['put', 'post'],'/updateStatus', 'setStatus')->name('status');
        Route::match(['put', 'post'],'/approve-licence', 'licenseStatusUpdate')->name('licence.status.update');
        Route::match(['put','post'],'/update/settings','updateSettings')->name('settings');
    });
    Route::group(['as'  => 'delete.'], function() {
        Route::delete('/deleteData', 'deleteData')->name('data');
        Route::post('/remove-media', 'removeMedia')->name('data');
    });

});
Route::namespace('Admin')->controller(AjaxController::class)->as('ajax.')->group(function () {
    Route::get('/getCities', 'getCities')->name('get.cities');
});

Route::controller(FrontendAjaxController::class)->as('frontend.ajax.')->group(function () {
    Route::post('/getProducts','findProducts')->name('get.products');
    Route::post('/add-to-cart','addToCart')->name('add.to.cart');
    Route::post('/update-cart','updateCart')->name('update.cart');
    Route::post('/remove-from-cart','removeFromCart')->name('remove.from.cart');
    Route::post('/clear-cart','clearCart')->name('clear.cart');
    Route::post('/getBlogs','getBlogs')->name('get.blogs');
    Route::post('/store-pickup','storePickup')->name('store.pickup');
    Route::post('/submit-newsletter','submitNewsLetter')->name('submit.newsletter');
});

Route::controller(CustomerAjaxController::class)->prefix('customer')->as('ajax.customer.')->middleware(['auth','verified','role:customer'])->group(function () {
    Route::post('/findAddress','findAddress')->name('find.address');
    Route::post('/apply-coupon','applyCouponDiscountCart')->name('apply.coupon');
    Route::get('/remove-cart-coupon','removeCartCoupon')->name('remove.coupon');
    Route::post('/addAddress','addAddress')->name('add.address');
    Route::post('/defaultAddress','defaultAddress')->name('default.address');
    Route::post('/deleteAddress','deleteAddress')->name('delete.address');
    Route::post('/add-item-to-wishlist', 'addToWishlist')->name('add.to.wishlist');
    Route::post('/remove-item-from-wishlist', 'removeFromWishlist')->name('remove.from.wishlist');
    Route::post('/get-orders-by-type', 'getOrdersByType')->name('get.orders.by.type');
});
