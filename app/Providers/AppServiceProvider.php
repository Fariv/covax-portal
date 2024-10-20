<?php

namespace App\Providers;

use App\Services\Notifications\EmailNotification;
use App\Services\VaccineCenter\VaccineCenterService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EmailNotification::class, function ($app) {
            return new EmailNotification();
        });

        $this->app->singleton(VaccineCenterService::class, function ($app) {
            return new VaccineCenterService($app->make(EmailNotification::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
