<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (str_starts_with(config('app.url'), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Bagikan $errors global agar view form aman ketika dirender
        // di luar konteks request (mis. dari tinker / unit test). Pada request
        // HTTP normal, Laravel sudah menyediakannya via ViewErrorBag middleware.
        \Illuminate\Support\Facades\View::share('errors', session()->get('errors') ?? new \Illuminate\Support\ViewErrorBag());
    }
}
