<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class ReplicatingObserver extends ModelObserver
{
    private const REPLICATING_ACTION = 'Replicating';

    /**
     * Handle the Model "replicating" event.
     *
     * @param Model $model
     * @return void
     */
    public function replicating(Model $model)
    {
        $this->logAction($model, self::REPLICATING_ACTION);
    }
}