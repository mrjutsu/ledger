<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
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
        
        $replicated = filter_var($this->getMetaValue($model, LedgerMeta::META_KEY), FILTER_VALIDATE_BOOLEAN);

        $this->logAction($model, $replicated ? self::REPLICATED_ACTION : self::SAVED_ACTION, $details);
        
        $this->removeMeta($model, LedgerMeta::META_KEY);
    }
}