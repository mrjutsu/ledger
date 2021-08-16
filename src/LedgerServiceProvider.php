<?php

namespace Mrjutsu\Ledger;

use Illuminate\Support\ServiceProvider;

class LedgerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../stubs/ledger.php' => config_path('ledger.php'),
        ], 'ledger-config');
        
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'ledger-migrations');
    }
    
}
