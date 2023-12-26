<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Ledger;

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
        $this->logAction($model, Ledger::RESTORED_ACTION);
    }
}