<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class SavingObserver extends ModelObserver
{
    private const SAVING_ACTION = 'Saving';

    /**
     * Handle the Model "saving" event.
     *
     * @param Model $model
     * @return void
     */
    public function saving(Model $model)
    {
        $this->logAction($model, self::SAVING_ACTION);
    }
}