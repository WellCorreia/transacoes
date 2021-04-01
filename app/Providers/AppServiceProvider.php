<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Services\WalletService;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\WalletServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class,
        );
        $this->app->bind(
            WalletServiceInterface::class,
            WalletService::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
