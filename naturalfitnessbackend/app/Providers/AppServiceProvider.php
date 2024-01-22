<?php

namespace App\Providers;

use App\Models\Site\Category;
use App\Models\Vehicle\Vehicle;
use Laravel\Passport\Passport;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
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
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        Validator::extend('reg_unique', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $registration_number = strtolower(clean($inputs['registration_number']));
            $except_id = (!empty($parameters) && count($parameters) > 2) ? (int)$parameters[2] : null;
            //$query = Vehicle::whereRaw("LOWER(PREG_REPLACE('/[^a-zA-Z0-9]+/', '', `registration_number`)) LIKE '%". $registration_number."%'");
            $query = Vehicle::whereRaw("REPLACE(REPLACE(`registration_number`, '-', ''), ' ', '') LIKE '%". $registration_number."%'");
            if(!empty($except_id)) {
              $query->where('id', '<>', $except_id);
            }
            return !$query->exists();
        });
    }


}
