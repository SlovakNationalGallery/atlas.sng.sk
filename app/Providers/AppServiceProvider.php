<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\Section;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Client\PendingRequest;
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
        foreach ([Http::class, PendingRequest::class] as $class) {
            $class::macro(
                'webumenia',
                fn() => $class
                    ::withHeaders([
                        'Accept-Language' => app()->getLocale(),
                    ])
                    ->baseUrl(config('services.webumenia.api'))
            );
        }

        Http::macro(
            'vimeo',
            fn() => Http::withHeaders([
                'Authorization' => sprintf('bearer %s', config('services.vimeo.access_token')),
                'Accept' => sprintf('application/vnd.vimeo.*+json;version=%s', config('services.vimeo.api_version')),
            ])->baseUrl(config('services.vimeo.api'))
        );

        Relation::morphMap([
            'item' => Item::class,
            'section' => Section::class,
        ]);
    }
}
