<?php

namespace Mrjutsu\Ledger;

use Illuminate\Support\ServiceProvider;
use Mrjutsu\Ledger\Console\InstallCommand;

class LedgerServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->commands(
            [
                InstallCommand::class,
            ]
        );
    }

}
