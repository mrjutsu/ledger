<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Ledger;

class DeletingObserver extends ModelObserver
{
    /**
     * Handle the Model "deleting" event.
     *
     * @param Model $model
     * @return void
     */
    public function deleting(Model $model)
    {
        $this->logAction($model, Ledger::DELETING_ACTION);
    }
}