<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCPDF;

class TCPDFServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('tcpdf', function ($app) {
            // Return a new instance of TCPDF with desired configuration
            return new TCPDF();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
