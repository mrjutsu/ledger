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

    private $defaultEvents = [
        'created',
        'updated',
        'deleted',
        'forceDeleted'
    ];

    protected static $ledgerObservers = [
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

    public static function bootLoggable()
    {
        $observers = array_merge(self::$ledgerObservers, static::OBSERVERS ?? []);
        $events = static::EVENTS_LOGGED ?: self::$defaultEvents;
        
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
     * */
    public function getLoggedFields()
    {
        /*
         * Ignore the primary key and the timestamps if used
         * */
        $this->fieldsIgnored = array_merge($this->fieldsIgnored ?? [], [$this->primaryKey], $this->timestamps ? [static::CREATED_AT, static::UPDATED_AT] : []);

        $fields = $this->fieldsLogged ?? [];
        if (in_array('*', $this->fieldsLogged)) {
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
        
        $this->ledgerLogs()->create([
            'action' => $action,
            'details' => $details,
            'user_id' => auth()->id()
        ]);
    }

}
