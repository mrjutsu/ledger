<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Ledger;

class DeletedObserver extends ModelObserver
{

    /**
     * Handle the Model "deleted" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $details = $this->parseDetails($model);
        
        $this->logAction($model, Ledger::DELETED_ACTION, $details);
    }

}
