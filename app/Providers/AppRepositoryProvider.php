<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\Interfaces\WalletRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->bind(
            WalletRepositoryInterface::class,
            WalletRepository::class,
        );

        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
