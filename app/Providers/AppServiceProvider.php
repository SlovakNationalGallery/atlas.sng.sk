<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Http::macro('webumenia', function () {
            return Http::withHeaders([
                'Accept-Language' => app()->getLocale(),
            ])->baseUrl(config('services.webumenia.api'));
        });
    }
}
