<?php

namespace App\Providers;

use App\Models\User;
use App\RolesEnum;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->enforceSecureUrls();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View pagination
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');
    }

    private function enforceSecureUrls(): void
    {
        if (!$this->app->environment('local')) {
            URL::forceScheme('https');
        }
    }
}
