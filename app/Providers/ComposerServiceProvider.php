<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.09.2016
 * Time: 13:48
 */

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
       // Если композер реализуется при помощи класса:
        View::composer('cart', 'App\Http\Composers\ProfileComposer');

        View::composer('header.header', 'App\Http\Composers\CardCountComposer');
        View()->composer('*',  'App\Http\ViewComposers\MenuComposer');
        // Если композер реализуется в функции-замыкании:
        View::composer('header.header', function()
        {

        });
    }

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        //
    }

}