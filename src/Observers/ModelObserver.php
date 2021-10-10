<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Models\LedgerLog;

class ModelObserver
{
    const CREATED_ACTION = 'Created';
    const CREATING_ACTION = 'Creating';
    const DELETED_ACTION = 'Deleted';
    const DELETING_ACTION = 'Deleting';
    const FORCE_DELETED_ACTION = 'Force Deleted';
    const REPLICATING_ACTION = 'Replicating';
    const RESTORED_ACTION = 'Restored';
    const RESTORING_ACTION = 'Restoring';
    const SAVED_ACTION = 'Saved';
    const SAVING_ACTION = 'Saving';
    const UPDATED_ACTION = 'Updated';
    const UPDATING_ACTION = 'Updating';

    protected function logAction(Model $model, string $action, string $details = null)
    {
        $model->ledgerLogs()->create([
            'action' => $action,
            'details' => $details,
            'user_id' => auth()->id()
        ]);
    }
    
    protected function parseDetails(Model $model)
    {
        return json_encode($model->toArray());
    }

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
     */
    protected function deleteForceDeletePriorAction(Model $model)
    {
        $deletedLogsQuery = $model->ledgerLogs()->where(LedgerLog::ACTION, self::DELETED_ACTION);
        $deletedLogsCount = (clone $deletedLogsQuery)->count();

        if ($deletedLogsCount > 1) {
            $deletedLogsQuery->orderBy('id', 'DESC')->first()->delete();
        }
    }
}
