<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class ForceDeletedObserver extends ModelObserver
{

    private const FORCE_DELETED_ACTION = 'Force Deleted';

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

}
