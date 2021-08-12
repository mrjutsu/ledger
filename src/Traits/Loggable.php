<?php

namespace Mrjutsu\Ledger\Traits;

use Mrjutsu\Ledger\Models\LedgerLog;

trait Loggable {

    protected function bootLoggable()
    {
        // TODO: Boot the trait
    }

    /*
    * Registers a polymorphic relationship
    **/
    public function ledgerLogs()
    {
        return $this->morphMany(LedgerLog::class, 'loggable');
    }

}
