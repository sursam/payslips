<?php

namespace App\Providers;

use App\Models\Category;
use Laravel\Passport\Passport;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        Paginator::useBootstrap();
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        if (!Collection::hasMacro('paginate')) {
            Collection::macro(
                'paginate',
                function ($perPage = 14, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    ))->withPath('');
                }
            );
        }

        View::composer(['frontend.layouts.partials.navbar','frontend.index'], function ($view) {
            $masterCategories = Category::whereNull('parent_id')->get();
            $headerPages = \App\Models\Menu::where('status', 1)->where('is_header',true)->orderBy('id', 'asc')->get();
            // dd($headerPages);
            $view->with(['masterCategories'=> $masterCategories,'headerPages' => $headerPages]);
        });

        View::composer('frontend.layouts.partials.footer', function ($view) {
            $pages = \App\Models\Menu::where('status', 1)->where('is_footer',true)->orderBy('id', 'asc')->get();
            $view->with(['pages' => $pages]);
        });

        View::composer(['frontend.layouts.partials.cart','frontend.layouts.partials.navbar'], function ($view) {
            $cartProducts = auth()->user()?->carts ?? session()->get('cart',[]);
            $view->with(['cartProducts' => $cartProducts]);
        });

    }
}
