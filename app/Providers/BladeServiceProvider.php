<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
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
        Blade::component('components.delete_button', 'deletebutton');
        Blade::component('fields.field', 'fieldblock');
        Blade::component('components.content');

        Blade::include('components.alert');
        Blade::include('components.breadcrumb');
        Blade::include('components.datatable');

        Blade::directive('field', function ($expression) {
            return "<?php echo field($expression); ?>";
        });

        Blade::directive('route', function ($expression) {
            return "<?php echo route($expression); ?>";
        });

        Blade::directive('routeAdmin', function ($expression) {
            return "<?php echo route_admin($expression); ?>";
        });
    }
}
