<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

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
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));
    }
}
