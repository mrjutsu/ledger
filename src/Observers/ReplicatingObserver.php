<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class ReplicatingObserver extends ModelObserver
{
    /**
     * Handle the Model "replicating" event.
     *
     * @param Model $model
     * @return void
     */
    public function replicating(Model $model)
    {
        $this->addMeta($model, self::REPLICATED_KEY, true);
    }
}