<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class RestoredObserver extends ModelObserver
{
    /**
     * Handle the Model "restored" event.
     *
     * @param Model $model
     * @return void
     */
    public function restored(Model $model)
    {
        $this->logAction($model, self::RESTORED_ACTION);
    }
}