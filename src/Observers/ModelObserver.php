<?php

namespace MrJutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

use MrJutsu\Ledger\Models\LedgerLog;

class ModelObserver
{

    public const FORCE_DELETED_ACTION = 'Force Deleted';

    /**
     * Handle the Model "forceDeleted" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        $this->logAction($model, self::FORCE_DELETED_ACTION);
    }

    protected function logAction(Model $model, string $action)
    {
        $model->loggable()->create([
            'action' => $action,
            'user_id' => auth()->id()
        ]);
    }
}
