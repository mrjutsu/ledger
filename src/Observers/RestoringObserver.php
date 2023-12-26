<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Ledger;

class RestoringObserver extends ModelObserver
{
    /**
     * Handle the Model "restoring" event.
     *
     * @param Model $model
     * @return void
     */
    public function restoring(Model $model)
    {
        $this->logAction($model, Ledger::RESTORING_ACTION);
    }
}