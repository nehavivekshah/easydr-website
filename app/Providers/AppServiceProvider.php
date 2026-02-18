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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $currency = \App\Models\Settings::where('key', 'currency_symbol')->first();
            $symbol = $currency ? $currency->value : '$';
        } catch (\Exception $e) {
            $symbol = '$';
        }

        view()->share('currency_symbol', $symbol);
    }
}
