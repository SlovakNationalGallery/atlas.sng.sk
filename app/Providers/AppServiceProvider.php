<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\Place;
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Database\Eloquent\Relations\Relation;

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
                fn () => $class
                    ::withHeaders([
                        'Accept-Language' => app()->getLocale(),
                    ])
                    ->baseUrl(config('services.webumenia.api'))
            );
        }

        Http::macro(
            'vimeo',
            fn () => Http::withHeaders([
                'Authorization' => sprintf('bearer %s', config('services.vimeo.access_token')),
                'Accept' => sprintf('application/vnd.vimeo.*+json;version=%s', config('services.vimeo.api_version')),
            ])->baseUrl(config('services.vimeo.api'))
        );

        Relation::morphMap([
            'item' => Item::class,
            'section' => Section::class,
            'place' => Place::class,
        ]);

        Str::macro('markdownWithLineBreaks', function ($value) {
            return Str::of($value)
                ->replaceMatches('/\*\*(\s*)(.*?)(\s*)\*\*/', '$1**$2**$3')
                ->replaceMatches('/_(\s*)(.*?)(\s*)_/', '$1_$2_$3')
                ->replaceMatches('/~~(\s*)(.*?)(\s*)~~/', '$1~~$2~~$3')
                ->markdown([
                    'renderer' => [
                        'soft_break' => '<br />',
                    ],
                ])
                ->remove('**');
        });

        Stringable::macro('markdownWithLineBreaks', function () {
            return Str::markdownWithLineBreaks($this->value);
        });
    }
}
