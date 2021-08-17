<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class SavedObserver extends ModelObserver
{
    private const SAVED_ACTION = 'Saved';

    /**
     * Handle the Model "saved" event.
     *
     * @param Model $model
     * @return void
     */
    public function saved(Model $model)
    {
        $this->logAction($model, self::SAVED_ACTION);
    }
}