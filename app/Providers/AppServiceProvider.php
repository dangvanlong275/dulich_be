<?php

namespace App\Providers;

use App\Repositories\AuthRepo;
use App\Repositories\Interfaces\AuthInterface;
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
        $this->app->singleton(AuthInterface::class, AuthRepo::class);
    }
}
