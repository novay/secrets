<?php

namespace Novay\Secret;

use Illuminate\Support\ServiceProvider;

class SecretServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Secret::class, function ($app) {
            $baseUri = env('SECRET_URI', 'https://btekno.id');
            $apiKey = env('SECRET_KEY', 'your-api-key-here');

            return new Secret($baseUri, $apiKey);
        });
    }

    public function boot()
    {
        //
    }
}