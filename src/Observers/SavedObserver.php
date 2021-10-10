<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class SavedObserver extends ModelObserver
{
    /**
     * Handle the Model "saved" event.
     *
     * @param Model $model
     * @return void
     */
    public function saved(Model $model)
    {
        $details = $this->maybeGetChangedFields($model);
        
        $replicated = $model->checkIfWasReplicated;

        $this->logAction($model, $replicated ? self::REPLICATED_ACTION : self::SAVED_ACTION, $details);
    }
}