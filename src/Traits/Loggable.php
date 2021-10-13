<?php

namespace Mrjutsu\Ledger\Traits;

use Mrjutsu\Ledger\Models\LedgerLog;
use Mrjutsu\Ledger\Observers\ModelObserver;

use Mrjutsu\Ledger\Observers\CreatedObserver;
use Mrjutsu\Ledger\Observers\UpdatingObserver;
use Mrjutsu\Ledger\Observers\UpdatedObserver;
use Mrjutsu\Ledger\Observers\SavedObserver;
use Mrjutsu\Ledger\Observers\DeletingObserver;
use Mrjutsu\Ledger\Observers\DeletedObserver;
use Mrjutsu\Ledger\Observers\RestoringObserver;
use Mrjutsu\Ledger\Observers\RestoredObserver;
use Mrjutsu\Ledger\Observers\ForceDeletedObserver;

trait Loggable {

    private static $defaultEvents = [
        'created',
        'updated',
        'deleted',
        'forceDeleted'
    ];

    private static $ledgerObservers = [
        'created' => CreatedObserver::class,
        'updating' => UpdatingObserver::class,
        'updated' => UpdatedObserver::class,
        'saved' => SavedObserver::class,
        'deleting' => DeletingObserver::class,
        'deleted' => DeletedObserver::class,
        'restoring' => RestoringObserver::class,
        'restored' => RestoredObserver::class,
        'forceDeleted' => ForceDeletedObserver::class,
    ];

    public static function bootLoggable()
    {
        $observers = array_merge(self::$ledgerObservers, defined('static::OBSERVERS') ? static::OBSERVERS : []);
        $events = defined('static::EVENTS_LOGGED') ? static::EVENTS_LOGGED : self::$defaultEvents;
        
        static::observe(
            array_map(function($event) use ($observers) {
                return $observers[$event];
            }, $events)
        );
    }

    /**
    * Registers a polymorphic relationship between the model and LedgerLog
    */
    public function ledgerLogs()
    {
        return $this->morphMany(LedgerLog::class, 'loggable');
    }

    /*
     * Returns all the logged fields for the given model
     */
    public function getLoggedFields()
    {
        /*
         * Ignore the primary key and the timestamps if used
         * */
        $this->fieldsIgnored = array_merge(defined('static::FIELDS_IGNORED') ? static::FIELDS_IGNORED : [], [$this->primaryKey], $this->timestamps ? [static::CREATED_AT, static::UPDATED_AT] : []);

        $fields = defined('static::FIELDS_LOGGED') ? static::FIELDS_LOGGED : [];
        if (in_array('*', $fields)) {
            $fields = array_keys($this->getAttributes());
        }
        
        return array_diff($fields, $this->fieldsIgnored);
    }

    /**
     * Logs a custom action for the given model.
     *
     * @param string $action
     * @param null $details
     */
    public function log(string $action, $details = null)
    {
        if (is_array($details)) {
            $details = json_encode($details);
        }
        
        $this->ledgerLogs()->create(
            array_merge(
                [
                    LedgerLog::ACTION => $action,
                    LedgerLog::DETAILS => $details,
                ], $this->ledgerDefaults()
            )
        );
    }

    /**
     * Overrides the parent's replicate method in order to properly log the Replicating action.
     * 
     * @param array|null $except
     */
    public function replicate(array $except = null)
    {
        /**
         * Check if the user wants to log the Replicating action for this model.
        */
        $logReplicatingAction = defined('static::LOG_REPLICATING_ACTION') ? static::LOG_REPLICATING_ACTION : true;
        
        if ($logReplicatingAction) {
            /**
             * Log the current model as being currently replicated before the parent's method creates a new instance
             */
            $this->log(ModelObserver::REPLICATING_ACTION);
        }

        parent::replicate();
    }
    
    /**
     * Return an array containing the default values that will always be logged.
     */
    public function ledgerDefaults()
    {
        return [
            LedgerLog::USER_ID => auth()->id(),
            LedgerLog::IP => request()->ip(),
            LedgerLog::USER_AGENT => request()->userAgent()
        ];
    }

}
