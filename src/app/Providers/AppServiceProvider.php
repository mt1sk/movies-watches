<?php

namespace App\Providers;

use App\Movie;
use App\User;
use Illuminate\Support\ServiceProvider;

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
        User::deleting(function (User $user) {
            $user->movies->each->delete();
        });
        Movie::deleting(function (Movie $movie) {
            $movie->watches->each->delete();
        });
    }
}
