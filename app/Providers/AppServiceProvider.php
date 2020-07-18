<?php

namespace App\Providers;

use App\Http\View\Composers\CMMenuComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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

        View::composer(['partials.cm-menu', 'dashboard.index'], CMMenuComposer::class);
    }
}
