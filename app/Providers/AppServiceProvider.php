<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Auth\AuthManager;

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
        Gate::define('superadmin',function(User $user){
            return $user->user_role == 'superadmin';
        });

        Gate::define('admin',function(User $user){
            return $user->user_role == 'admin';
        });

        Gate::define('user',function(User $user){
            return $user->user_role == 'user';
        });

        Gate::define('adminOrSuperadmin', function ($user) {
            return $user->user_role === 'admin' || $user->user_role === 'superadmin';
        });
        
    }
}
