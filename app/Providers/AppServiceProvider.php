<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Gates for roles
        Gate::define('isClient', fn($user) => $user->role === 'client');
        Gate::define('isRestaurateur', fn($user) => $user->role === 'restaurateur');
    }
}
