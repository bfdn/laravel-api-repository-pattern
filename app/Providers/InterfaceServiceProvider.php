<?php

namespace App\Providers;

use App\Interfaces\Eloquent\IAuthService;
use App\Interfaces\Eloquent\IUserService;
use App\Repositories\UserRepository;
use App\Services\Eloquent\AuthService;
use App\Services\Eloquent\UserService;
use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            IAuthService::class,
            AuthService::class
        );
        $this->app->bind(
            IUserService::class,
            // UserService::class
            UserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
