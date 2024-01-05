<?php

use Illuminate\Support\Facades\Route;

Route::namespace ('Admin')->as('admin.')->middleware(['auth', 'verified', 'role:super-admin|admin|sub-admin|store-manager|order-manager|seller'])->group(function () {

    Route::controller(MenuController::class)->prefix('menu')->as('menu.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add', 'create')->name('add');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
    });

    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('home');
        Route::match(['get', 'post'], '/change-password', 'changePassword')->name('change.password');
        Route::match(['get', 'post'], '/profile', 'profile')->name('profile');
        Route::get('/admin-users', 'adminUser')->name('user.list');
        Route::match(['get', 'post'], '/admin-users/edit/{uuid}', 'adminUserEdit')->name('user.edit');
        Route::match(['get', 'post'], '/admin-users/{uuid}/attach-permission/', 'attachPermission')->name('user.attach.permission');
    });

    Route::controller(SellerController::class)->as('seller.')->prefix('sellers')->group(function () {
        Route::get('/', 'listSellers')->name('list');
        Route::get('/add', 'addSellers')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editSellers')->name('edit');
        Route::get('/delete/{uuid}', 'deleteSellers')->name('delete');
    });
    Route::controller(SubscriberController::class)->as('subscriber.')->prefix('subscriber')->group(function () {
        Route::get('/list', 'index')->name('list');
        Route::get('/export-news-letters', 'exportNewsLetters')->name('export');
    });

    Route::controller(CustomerController::class)->as('customer.')->prefix('customers')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add', 'addCustomers')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editCustomers')->name('edit');
        Route::get('/delete/{uuid}', 'deleteCustomers')->name('delete');
        Route::get('/view-address/{uuid}', 'viewAddress')->name('view.address');
        Route::match(['get', 'post'], '/update-address/{uuid}', 'editAddress')->name('update.address');
    });

    Route::controller(DeliveryAgentController::class)->as('delivery.agent.')->prefix('delivery-agents')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/view/{uuid}', 'view')->name('view');
        Route::match(['get','post'],'/{uuid}/payouts', 'payouts')->name('payouts');
        Route::get('/add', 'addAgents')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editAgents')->name('edit');
        Route::get('/delete/{uuid}', 'deleteAgents')->name('delete');
    });

    Route::controller(CouponController::class)->as('coupon.')->prefix('coupons')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add', 'addCoupon')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editCoupon')->name('edit');
        Route::get('/delete/{uuid}', 'deleteCoupons')->name('delete');
    });

    Route::controller(BlogController::class)->as('blog.')->prefix('blogs')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'addBlog')->name('add');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editBlog')->name('edit');
        Route::get('/delete/{uuid}', 'deleteBlogs')->name('delete');
    });
    Route::controller(ContentController::class)->as('content.')->prefix('contents')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], '/add', 'addContent')->name('add');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editContent')->name('edit');
        Route::get('/delete/{uuid}', 'deleteContents')->name('delete');
    });
    Route::controller(RoleController::class)->as('role.')->prefix('roles')->group(function () {
        Route::get('/', 'listRoles')->name('list');
        Route::get('/add', 'addRoles')->name('add');
        Route::post('/save', 'saveRoles')->name('save');
        Route::match(['get', 'post'], '/{id}/attach-permission', 'attachPermission')->name('attach.permission');
    });
    /* will be blocked for now. if needed permission will be open */

    /* Route::controller(RoleController::class)->as('permission.')->prefix('permissions')->group(function () {
    Route::get('/', 'listPermissions')->name('list');
    Route::get('/add', 'addPermissions')->name('add');
    Route::post('/save', 'savePermissions')->name('save');
    }); */

    Route:: as ('catalog.')->group(function () {
        /* Need to move in catalog name group on line 21 */
        Route::controller(CategoryController::class)->as('category.')->prefix('categories')->group(function () {
            Route::get('/', 'viewCategory')->name('list');
            Route::get('details/{uuid}', 'categoryDetails')->name('view');
            Route::match(['get', 'post'], 'add', 'addCategory')->name('add');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editCategory')->name('edit');
            Route::post('/getCategories', 'getCategory')->name('get.categories');
            Route::get('/delete/{uuid}', 'deleteCategory')->name('delete');
        });
        Route::controller(CategoryController::class)->as('attribute.')->prefix('attribute')->group(function () {
            Route::get('/', 'viewAttribute')->name('list');
            Route::match(['get', 'post'], 'add', 'addAttribute')->name('add');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editAttribute')->name('edit');
            Route::post('/viewAttribute', 'viewAttribute')->name('view');
            Route::get('/delete/{uuid}', 'deleteAttribute')->name('delete');
            Route::match(['get', 'post'], 'Addvalue', 'addAttributeValue')->name('value.add');
        });
        Route::controller(ProductController::class)->as('product.')->prefix('products')->group(function () {
            Route::match(['get', 'post'], '/', 'index')->name('list');
            Route::match(['get', 'post'], 'add', 'addProduct')->name('add');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editProduct')->name('edit');
            Route::match(['get', 'post', 'put'], 'view/{uuid}', 'viewProduct')->name('view.gallery');
            Route::get('/delete/{uuid}', 'deleteProduct')->name('delete');
        });
        Route::controller(BrandController::class)->as('brand.')->prefix('brands')->group(function () {
            Route::get('/', 'viewBrand')->name('list');
            Route::match(['get', 'post'], 'add', 'addBrand')->name('add');
            Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editBrand')->name('edit');
            Route::get('/delete/{uuid}', 'deleteBrand')->name('delete');
        });

    });

    Route::controller(InvitationController::class)->as('invitation.')->group(function () {
        Route::get('/invitation-list', 'list')->name('list');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::match(['get', 'post'], '/{uuid}/attach-permission', 'attachPermission')->name('attach.permission');
    });

    Route::controller(BannerController::class)->as('banner.')->prefix('banners')->group(function () {
        Route::get('/', 'viewBanners')->name('list');
        Route::match(['get', 'post'], '/add', 'addBanner')->name('add');
        Route::match(['get', 'post'], '/edit/{uuid}', 'EditBanner')->name('edit');
        Route::get('/delete/{uuid}', 'deleteBanner')->name('delete');
    });

    Route::controller(PagesController::class)->as('page.')->prefix('pages')->group(function () {
        Route::get('/', 'viewPage')->name('list');
        Route::match(['get', 'post'], 'add', 'addPage')->name('add');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editPage')->name('edit');
        Route::get('/delete/{uuid}', 'deletePage')->name('delete');
    });

    Route::controller(FaqController::class)->as('faq.')->prefix('faqs')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::match(['get', 'post'], 'add', 'addFaq')->name('add');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editFaq')->name('edit');
        Route::get('/delete/{uuid}', 'deleteFaq')->name('delete');
    });

    Route::controller(TestimonialController::class)->as('testimonial.')->prefix('testimonials')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add', 'addTestimonialReviews')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editTestimonialReviews')->name('edit');
    });

    Route::controller(StoreController::class)->as('store.')->prefix('stores')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/add', 'addStoreLocation')->name('add');
        Route::post('/save', 'store')->name('save');
        Route::match(['get', 'post', 'put'], 'edit/{uuid}', 'editStoreLocation')->name('edit');
    });

    Route::controller(SiteSettingController::class)->as('setting.')->prefix('setting')->group(function(){
        Route::get('/','index')->name('list');

    });
    Route::controller(ShippingCostController::class)->as('shipping.cost.')->prefix('shipping-cost')->group(function(){
        Route::get('/','index')->name('list');
        Route::match(['get','post'],'/add','add')->name('add');

    });

    Route::controller(OrderManagementController::class)->as('order.')->prefix('orders')->group(function(){
        Route::get('list','index')->name('list');
        Route::get('view/{uuid}','viewOrder')->name('view');
    });
    Route::controller(DeliveryController::class)->prefix('delivery')->as('inventory.delivery.')->group(function(){
        Route::get('/','index')->name('list');
        Route::get('/edit/{uuid}','edit')->name('edit');
        Route::post('/assign/agent/{uuid}','assignAgent')->name('assign.agent');
    });

    Route::controller(TransactionController::class)->as('transaction.')->prefix('transaction')->group(function(){
        Route::get('/','index')->name('list');
        Route::get('/view/{uuid}','view')->name('view');
    });

});

Route::post('admin/logout', 'Auth\LoginController@adminLogout')->name('admin.logout');

