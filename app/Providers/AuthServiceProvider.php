<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Gate::define('show-this', function ($user, $table_name) {
            foreach ($user->projects as $project) {
                // from session biasanya string, karenaya kita makai == bukan, ====
                if ($project->id == request()->session()->get('project')["id"]) {
                    // dd($project->entities);
                    foreach ($project->entities as $entity) {
                        if ($entity->table_name == $table_name) {
                            return true;
                        }
                    };

                    return false;
                }
            };

            return false;
        });
    }
}
