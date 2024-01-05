<?php

namespace App\Providers;

use App\Contracts\Faq\FaqContract;
use App\Contracts\Blog\BlogContract;
use App\Contracts\Content\ContentContract;
use App\Contracts\Menu\MenuContract;
use App\Contracts\Page\PageContract;
use App\Contracts\Role\RoleContract;
use App\Contracts\Users\UserContract;
use App\Contracts\Brand\BrandContract;
use App\Contracts\Order\OrderContract;
use App\Contracts\Store\StoreContract;
use App\Contracts\Users\InviteContract;
use App\Repositories\Faq\FaqRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Banner\BannerContract;
use App\Contracts\Coupon\CouponContract;
use App\Contracts\Location\CityContract;
use App\Contracts\Shipping\CostContract;
use App\Contracts\Location\StateContract;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\Content\ContentRepository;
use App\Repositories\Menu\MenuRepository;
use App\Repositories\Page\PageRepository;
use App\Repositories\Role\RoleRepository;
use App\Contracts\Payment\PaymentContract;
use App\Contracts\Product\ProductContract;
use App\Repositories\Users\UserRepository;
use App\Contracts\Frontend\ContactContract;
use App\Contracts\Location\CountryContract;
use App\Repositories\Brand\BrandRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Store\StoreRepository;
use App\Contracts\Category\CategoryContract;
use App\Repositories\Users\InviteRepository;
use App\Repositories\Banner\BannerRepository;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Location\CityRepository;
use App\Repositories\Shipping\CostRepository;
use App\Repositories\Location\StateRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Frontend\ContactRepository;
use App\Repositories\Location\CountryRepository;
use App\Repositories\Category\CategoryRepository;
use App\Contracts\Testimonial\TestimonialContract;
use App\Contracts\Transaction\TransactionContract;
use App\Repositories\Testimonial\TestimonialRepository;
use App\Repositories\Transaction\TransactionRepository;

class RepositoryServiceProvider extends ServiceProvider
{

    protected $repositories = [
        UserContract::class => UserRepository::class,
        RoleContract::class => RoleRepository::class,
        InviteContract::class => InviteRepository::class,
        CategoryContract::class => CategoryRepository::class,
        ContactContract::class => ContactRepository::class,
        BannerContract::class => BannerRepository::class,
        PageContract::class => PageRepository::class,
        ProductContract::class => ProductRepository::class,
        MenuContract::class => MenuRepository::class,
        CouponContract::class => CouponRepository::class,
        BrandContract::class => BrandRepository::class,
        BlogContract::class => BlogRepository::class,
        ContentContract::class => ContentRepository::class,
        FaqContract::class => FaqRepository::class,
        TestimonialContract::class => TestimonialRepository::class,
        StoreContract::class => StoreRepository::class,
        PaymentContract::class => PaymentRepository::class,
        OrderContract::class => OrderRepository::class,
        CostContract::class => CostRepository::class,
        CountryContract::class => CountryRepository::class,
        StateContract::class => StateRepository::class,
        CityContract::class => CityRepository::class,
        TransactionContract::class => TransactionRepository::class
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
