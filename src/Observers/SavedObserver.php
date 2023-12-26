<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Ledger;
use Mrjutsu\Ledger\Models\LedgerMeta;

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
        
        $this->logAction($model, Ledger::SAVED_ACTION, $details);
    }
}