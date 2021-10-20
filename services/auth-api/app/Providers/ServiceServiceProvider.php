<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Contracts\{
    AuthServiceInterface,
    UserServiceInterface
};
use App\Services\{
    AuthService,
    UserService
};

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        AuthServiceInterface::class => AuthService::class,
        UserServiceInterface::class => UserService::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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
