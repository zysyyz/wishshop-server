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
        // //
        // $this->app->singleton(\Faker\Generator::class, function () {
        //     return \Faker\Factory::create('zh_CN');
        // });
    }
}
