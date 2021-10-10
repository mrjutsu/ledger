<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Models\LedgerLog;
use Mrjutsu\Ledger\Models\LedgerMeta;

class ModelObserver
{
    const CREATED_ACTION = 'Created';
    const CREATING_ACTION = 'Creating';
    const DELETED_ACTION = 'Deleted';
    const DELETING_ACTION = 'Deleting';
    const FORCE_DELETED_ACTION = 'Force Deleted';
    const REPLICATED_ACTION = 'Replicated';
    const RESTORED_ACTION = 'Restored';
    const RESTORING_ACTION = 'Restoring';
    const SAVED_ACTION = 'Saved';
    const SAVING_ACTION = 'Saving';
    const UPDATED_ACTION = 'Updated';
    const UPDATING_ACTION = 'Updating';
    
    const REPLICATED_KEY = 'Replicated';

    protected function logAction(Model $model, string $action, string $details = null)
    {
        $model->ledgerLogs()->create([
            'action' => $action,
            'details' => $details,
            'user_id' => auth()->id()
        ]);
    }
    
    /**
     * Adds a meta for the given model with the given key and value.
     * 
     * @param Model $model
     * @param string $key
     * @param string $value
     */
    protected function addMeta(Model $model, string $key, string $value)
    {
        $model->ledgerMeta()->create([
            LedgerMeta::META_KEY => $key,
            LedgerMeta::META_VALUE => $value
        ]);
    }
    
    /**
     * Returns the first found LedgerMeta record for the given model with the given key.
     * 
     * @param Model $model
     * @param string $key
     * @return Model|null
     */
    protected function getMeta(Model $model, string $key)
    {
        return $model->ledgerMeta()->where(LedgerMeta::META_KEY, $key)->first();
    }

    /**
     * Returns the value of the LedgerMeta record found for the given model with the given key.
     *
     * @param Model $model
     * @param string $key
     * @return mixed|null
     */
    protected function getMetaValue(Model $model, string $key)
    {
        $meta = $this->getMeta($model, $key);

        if ($meta) {
            return $meta->meta_value;
        }
        
        return null;
    }
    
    /**
     * Deletes the first LedgerMeta record found for the given model with the given key.
     * 
     * @param Model $model
     * @param string $key
     */
    protected function removeMeta(Model $model, string $key)
    {
        $meta = $this->getMeta($model, $key);

        if ($meta) {
            $meta->delete();
        }
    }
    
    /**
     * Returns an encoded string containing the model's data. This is used mainly when deleting a model to keep a record
     * of what was deleted when otherwise the data might be lost forever.
     *
     * @param Model $model
     * @return string|false
    */
    protected function parseDetails(Model $model)
    {
        return json_encode($model->toArray());
    }

    /**
     * Checks if the log_user_creation option is enabled. If so, logs the newly created user as a Registered action.
     *
    */
    protected function maybeLogUserRegistration(Model $model)
    {
        if (config('ledger.log_user_creation')) {
            $this->logAction($model, auth()->check() ? self::CREATED_ACTION : config('ledger.new_user_action'));
        }
    }

    /**
     * Deletes a model's Deleted action prior to the force deleted one. This is done only if there isn't another logged
     * Deleted action.
     *
     * @param Model $model
     */
    protected function deleteForceDeletePriorAction(Model $model)
    {
        $deletedLogsQuery = $model->ledgerLogs()->where(LedgerLog::ACTION, self::DELETED_ACTION);
        $deletedLogsCount = (clone $deletedLogsQuery)->count();

        if ($deletedLogsCount > 1) {
            $deletedLogsQuery->orderBy('id', 'DESC')->first()->delete();
        }
    }

    /**
     * Checks if any of the logged fields have been changed and returns a string containing the changes or null otherwise.
     *
     * @param Model $model
     * @return string|null
     */
    protected function maybeGetChangedFields(Model $model)
    {
        $loggedFields = $model->getLoggedFields();
        $details = null;

        if (!empty($loggedFields)) {
            $changes = [
                'fields' => []
            ];
            foreach ($model->getChanges() as $field => $value) {
                if (in_array($field, $loggedFields) && $model->isDirty($field)) {
                    $changes['fields'][$field] = [
                        'old' => $model->getOriginal($field),
                        'new' => $value
                    ];
                }
            }
            $details = json_encode($changes) ?: null;
        }

        return $details;
    }
}
