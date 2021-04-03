<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;
use App\Services\WalletService;
use App\Services\TransactionService;
use App\Services\NotificationService;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\WalletServiceInterface;
use App\Services\Interfaces\TransactionServiceInterface;
use App\Services\Interfaces\NotificationServiceInterface;

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

        $this->app->bind(
            TransactionServiceInterface::class,
            TransactionService::class,
        );

        $this->app->bind(
            NotificationServiceInterface::class,
            NotificationService::class,
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
