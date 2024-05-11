<?php

namespace App\Providers;

use App\Services\AppointmentService;
use App\Services\AuthService;
use App\Services\Interfaces\IAppointmentService;
use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IGoogleCalendarService;
use App\Services\GoogleCalendarService;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IAppointmentService::class, AppointmentService::class);
        $this->app->bind(IGoogleCalendarService::class, GoogleCalendarService::class);

        $this->app->register(RepositoryProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
