<?php
namespace Javad\Binance;

use Illuminate\Support\ServiceProvider;

class BinanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/../../config/binance.php' => config_path('binance.php')
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/binance.php', 'binance');
        $this->app->bind('binance', function() {
            return new BinanceAccountApi(config('binance'));
        });
    }
}
