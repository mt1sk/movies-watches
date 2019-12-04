<?php

namespace App\Providers;

use App\Movie;
use App\User;
use App\Watch;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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

        Gate::define('api-movie-show', function (User $user, Movie $movie) {
            return $user->ownsMovie($movie);
        });
        Gate::define('api-movie-update', function (User $user, Movie $movie) {
            return $user->ownsMovie($movie);
        });
        Gate::define('api-movie-delete', function (User $user, Movie $movie) {
            return $user->ownsMovie($movie);
        });

        Gate::define('api-watch-update', function (User $user, Watch $watch) {
            if ($watch->watchable instanceof Movie) {
                return $user->ownsMovie($watch->watchable);
            }
            return false;
        });
    }
}
