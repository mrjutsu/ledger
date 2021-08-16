<?php

namespace Mrjutsu\Ledger\Traits;

use Mrjutsu\Ledger\Models\LedgerLog;

use Mrjutsu\Ledger\Observers\CreatedObserver;
use Mrjutsu\Ledger\Observers\UpdatedObserver;
use Mrjutsu\Ledger\Observers\DeletedObserver;
use Mrjutsu\Ledger\Observers\ForceDeletedObserver;

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

    public static function bootLoggable()
    {
        static::observe(
            array_map(function($event) {
                return self::$eventsMap[$event];
            }, self::$eventsLogged)
        );
    }

    /**
    * Registers a polymorphic relationship between the model and LedgerLog
    */
    public function ledgerLogs()
    {
        return $this->morphMany(LedgerLog::class, 'loggable');
    }

    /**
    * Registers a relationship with the user responsible for the action performed
    */
    public function user()
    {
        return $this->belongsTo(config('ledger.user'), config('ledger.user_primary_key'));
    }

}
