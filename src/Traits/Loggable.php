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
    
    protected $retrievedObserver = RetrievedObserver::class;
    protected $creatingObserver = CreatingObserver::class;
    protected $createdObserver = CreatedObserver::class;
    protected $updatingObserver = UpdatingObserver::class;
    protected $updatedObserver = UpdatedObserver::class;
    protected $savingObserver = SavingObserver::class;
    protected $savedObserver = SavedObserver::class;
    protected $deletingObserver = DeletingObserver::class;
    protected $deletedObserver = DeletedObserver::class;
    protected $restoringObserver = RestoringObserver::class;
    protected $restoredObserver = RestoredObserver::class;
    protected $replicatingObserver = ReplicatingObserver::class;
    protected $forceDeletedObserver = ForceDeletedObserver::class;
    
    protected $fieldsLogged = [];
    protected $fieldsIgnored = [];

    public static function bootLoggable()
    {
        $eventsMap = [
            'retrieved' => static::$retrievedObserver,
            'creating' => static::$creatingObserver,
            'created' => static::$createdObserver,
            'updating' => static::$updatingObserver,
            'updated' => static::$updatedObserver,
            'saving' => static::$savingObserver,
            'saved' => static::$savedObserver,
            'deleting' => static::$deletingObserver,
            'deleted' => static::$deletedObserver,
            'restoring' => static::$restoringObserver,
            'restored' => static::$restoredObserver,
            'replicating' => static::$replicatingObserver,
            'forceDeleted' => static::$forceDeletedObserver,
        ];
        
        static::observe(
            array_map(function($event) use ($eventsMap) {
                return $eventsMap[$event];
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
