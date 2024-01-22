<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) : ?>";
        });

        Blade::directive('endrole', function ($role) {
            return "<?php endif; ?>";
        });

        /* Blade::directive('hasrole', function ($arguments) {
            $roles = explode('|', str_replace('"','',str_replace("'","",$arguments)));
            $userRoles= auth()->user()->roles?->pluck('slug')->toArray();
            $intersectedArray= array_intersect($userRoles,$roles);
            // dd(!empty($intersectedArray));
            return "<?php if (auth()->check() && !empty({$intersectedArray})): ?>";
        });

        Blade::directive('endhasrole', function () {
            return '<?php endif; ?>';
        }); */

    }
}
