<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
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
     * 这个界面的boot是在laravel启动时优先加载
     * @return void
     */
    public function boot()
    {
        //可以让diffFomHumans结果为中文
        Carbon::setLocale('zh');
        Schema::defaultStringLength(191);

    }
}
