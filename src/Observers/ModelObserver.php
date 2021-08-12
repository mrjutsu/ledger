<?php

namespace MrJutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

use MrJutsu\Ledger\Models\LedgerLog;

class ModelObserver
{

    public const CREATED_ACTION = 'Created';
    public const UPDATED_ACTION = 'Updated';
    public const DELETED_ACTION = 'Deleted';
    public const FORCE_DELETED_ACTION = 'Force Deleted';

    /**
     * Handle the Model "created" event.
     *
     * @param Model $model
     * @return void
     */
    public function created(Model $model)
    {
        $this->logAction($model, self::CREATED_ACTION);
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function updated(Model $model)
    {
        $this->logAction($model, self::UPDATED_ACTION);
    }

    /**
     * Handle the Model "deleted" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->logAction($model, self::DELETED_ACTION);
    }

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

    private function logAction(Model $model, string $action)
    {
        $model->loggable()->create([
            'action' => $action,
            'user_id' => auth()->id()
        ]);
    }
}
