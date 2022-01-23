<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
       /* Gate::before(function($user, $ability){
            if($user->type == 'super-admin'){
               // return false;
            }
        });
        Gate::define('create-product', function($user){
            return true;
        });
        Gate::define('delete-product', function($user){
            return false;
        });*/
        
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
