<?php

namespace Mrjutsu\Ledger\Traits;

use Mrjutsu\Ledger\Models\LedgerLog;

trait Loggable {

    protected function bootLoggable()
    {
        static::observe(ModelObserver::class);
    }

    /*
    * Registers a polymorphic relationship between the model and LedgerLog
    **/
    public function ledgerLogs()
    {
        return $this->morphMany(LedgerLog::class, 'loggable');
    }

    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }

}
