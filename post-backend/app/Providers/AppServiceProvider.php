<?php

namespace App\Providers;

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
        // Dao Registration
        $this->app->bind('App\Contracts\Dao\PostDaoInterface', 'App\Dao\PostDao');
        $this->app->bind('App\Contracts\Dao\AuthDaoInterface', 'App\Dao\AuthDao');
        $this->app->bind('App\Contracts\Dao\UserDaoInterface', 'App\Dao\UserDao');

        // Business logic registration
        $this->app->bind('App\Contracts\Service\PostServiceInterface', 'App\Service\PostService');
        $this->app->bind('App\Contracts\Service\AuthServiceInterface', 'App\Service\AuthService');
        $this->app->bind('App\Contracts\Service\UserServiceInterface', 'App\Service\UserService');
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
