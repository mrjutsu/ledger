<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class UpdatingObserver extends ModelObserver
{
    private const UPDATING_ACTION = 'Updating';

    /**
     * Handle the Model "updating" event.
     *
     * @param Model $model
     * @return void
     */
    public function updating(Model $model)
    {
        $this->logAction($model, self::UPDATING_ACTION);
    }
}