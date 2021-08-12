<?php

namespace Mrjutsu\Ledger\Traits;

use Mrjutsu\Ledger\Models\LedgerLog;

use MrJutsu\Ledger\Observers\CreatedObserver;
use MrJutsu\Ledger\Observers\UpdatedObserver;
use MrJutsu\Ledger\Observers\DeletedObserver;
use MrJutsu\Ledger\Observers\ForceDeletedObserver;

trait Loggable {

    public $eventsLogged = [
        'created',
        'updated',
        'deleted',
        'forceDeleted'
    ];

    private $eventsMap = [
        'created' => CreatedObserver::class,
        'updated' => UpdatedObserver::class,
        'deleted' => DeletedObserver::class,
        'forceDeleted' => ForceDeletedObserver::class,
    ];

    protected function bootLoggable()
    {
        static::observe(
            array_map(function($event) {
                return $this->eventsMap[$event];
            }, $this->eventsLogged)
        );
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
