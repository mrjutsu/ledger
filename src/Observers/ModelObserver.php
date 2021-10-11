<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Models\LedgerLog;
use Mrjutsu\Ledger\Models\LedgerMeta;

class ModelObserver
{
    const CREATED_ACTION = 'Created';
    const DELETED_ACTION = 'Deleted';
    const DELETING_ACTION = 'Deleting';
    const FORCE_DELETED_ACTION = 'Force Deleted';
    const REPLICATING_ACTION = 'Replicating';
    const RESTORED_ACTION = 'Restored';
    const RESTORING_ACTION = 'Restoring';
    const SAVED_ACTION = 'Saved';
    const UPDATED_ACTION = 'Updated';

    /**
     * Logs an action for the given model.
     *
     * @param Model $model
     * @param string $action
     * @param string|null $details
     */
    protected function logAction(Model $model, string $action, string $details = null)
    {
        $model->ledgerLogs()->create([
            'action' => $action,
            'details' => $details,
            'user_id' => auth()->id()
        ]);
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
