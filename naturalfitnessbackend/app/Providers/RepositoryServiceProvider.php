<?php

namespace App\Providers;


use App\Contracts\Faq\FaqContract;
use App\Contracts\Fare\FareContract;
use App\Contracts\Page\PageContract;
use App\Contracts\Zone\ZoneContract;
use App\Contracts\Users\UserContract;
use App\Repositories\Faq\FaqRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Location\StateContract;
use App\Repositories\Fare\FareRepository;
use App\Repositories\Page\PageRepository;
use App\Repositories\Zone\ZoneRepository;
use App\Contracts\Booking\BookingContract;
use App\Contracts\Company\CompanyContract;
use App\Contracts\Fare\HelperFareContract;
use App\Contracts\Medical\MedicalContract;
use App\Contracts\Payment\PaymentContract;
use App\Contracts\Product\ProductContract;
use App\Contracts\Support\SupportContract;
use App\Contracts\Vehicle\VehicleContract;
use App\Repositories\Users\UserRepository;
use App\Contracts\Frontend\ContactContract;
use App\Contracts\Location\CountryContract;
use App\Contracts\Category\CategoryContract;
use App\Contracts\Users\UserEnquiryContract;
use App\Contracts\Role\RolePermissionContract;
use App\Repositories\Location\StateRepository;
use App\Repositories\Booking\BookingRepository;
use App\Repositories\Company\CompanyRepository;
use App\Repositories\Fare\HelperFareRepository;
use App\Repositories\Medical\MedicalRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Support\SupportRepository;
use App\Repositories\Vehicle\VehicleRepository;
use App\Contracts\Support\SupportAnswerContract;
use App\Repositories\Frontend\ContactRepository;
use App\Repositories\Location\CountryRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Users\UserEnquiryRepository;
use App\Contracts\Transaction\TransactionContract;
use App\Repositories\Role\RolePermissionRepository;
use App\Contracts\Subscription\SubscriptionContract;
use App\Repositories\Support\SupportAnswerRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Subscription\SubscriptionRepository;

class RepositoryServiceProvider extends ServiceProvider
{

    protected $repositories = [

        ContactContract::class => ContactRepository::class,
        PageContract::class => PageRepository::class,
        FaqContract::class => FaqRepository::class,
        SupportContract::class => SupportRepository::class,
        SupportAnswerContract::class => SupportAnswerRepository::class,
        CategoryContract::class=> CategoryRepository::class,
        UserContract::class=> UserRepository::class,
        UserEnquiryContract::class=> UserEnquiryRepository::class,
        RolePermissionContract::class=> RolePermissionRepository::class,
        CountryContract::class=> CountryRepository::class,
        StateContract::class=> StateRepository::class,
        PaymentContract::class=> PaymentRepository::class,
        CompanyContract::class=> CompanyRepository::class,
        ProductContract::class => ProductRepository::class,
        SubscriptionContract::class => SubscriptionRepository::class,
        VehicleContract::class => VehicleRepository::class,
        FareContract::class => FareRepository::class,
        HelperFareContract::class => HelperFareRepository::class,
        BookingContract::class=> BookingRepository::class,
        ZoneContract::class => ZoneRepository::class,
        TransactionContract::class => TransactionRepository::class,
        MedicalContract::class => MedicalRepository::class,
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
