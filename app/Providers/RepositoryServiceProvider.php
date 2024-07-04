<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Route;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Route $route)
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UsersInterface::class, UsersRepository::class);

    }
}
