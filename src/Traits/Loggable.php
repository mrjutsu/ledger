<?php

namespace Mrjutsu\Ledger\Traits;

use Mrjutsu\Ledger\Models\LedgerLog;

use Mrjutsu\Ledger\Observers\RetrievedObserver;
use Mrjutsu\Ledger\Observers\CreatingObserver;
use Mrjutsu\Ledger\Observers\CreatedObserver;
use Mrjutsu\Ledger\Observers\UpdatingObserver;
use Mrjutsu\Ledger\Observers\UpdatedObserver;
use Mrjutsu\Ledger\Observers\SavingObserver;
use Mrjutsu\Ledger\Observers\SavedObserver;
use Mrjutsu\Ledger\Observers\DeletingObserver;
use Mrjutsu\Ledger\Observers\DeletedObserver;
use Mrjutsu\Ledger\Observers\RestoringObserver;
use Mrjutsu\Ledger\Observers\RestoredObserver;
use Mrjutsu\Ledger\Observers\ReplicatingObserver;
use Mrjutsu\Ledger\Observers\ForceDeletedObserver;

trait Loggable {

    public static $eventsLogged = [
        'created',
        'updated',
        'deleted',
        'forceDeleted'
    ];

    private static $eventsMap = [
        'retrieved' => RetrievedObserver::class,
        'creating' => CreatingObserver::class,
        'created' => CreatedObserver::class,
        'updating' => UpdatingObserver::class,
        'updated' => UpdatedObserver::class,
        'saving' => SavingObserver::class,
        'saved' => SavedObserver::class,
        'deleting' => DeletingObserver::class,
        'deleted' => DeletedObserver::class,
        'restoring' => RestoringObserver::class,
        'restored' => RestoredObserver::class,
        'replicating' => ReplicatingObserver::class,
        'forceDeleted' => ForceDeletedObserver::class,
    ];
    
    protected $fieldsLogged = [];
    
    protected $fieldsIgnored = [];

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

    /*
     * Returns all the logged fields for the given model
     * */
    public function getLoggedFields()
    {
        /*
         * Ignore the primary key and the timestamps if used
         * */
        $this->fieldsIgnored = array_merge($this->fieldsIgnored, [$this->primaryKey], $this->timestamps ? [static::CREATED_AT, static::UPDATED_AT] : []);

        $fields = $this->fieldsLogged;
        if (in_array('*', $this->fieldsLogged)) {
            $fields = array_keys($this->getAttributes());
        }
        
        return array_diff($fields, $this->fieldsIgnored);
    }

}
