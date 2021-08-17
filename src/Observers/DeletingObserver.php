<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class DeletingObserver extends ModelObserver
{
    private const DELETING_ACTION = 'Deleting';

    /**
     * Handle the Model "deleting" event.
     *
     * @param Model $model
     * @return void
     */
    public function deleting(Model $model)
    {
        $this->logAction($model, self::DELETING_ACTION);
    }
}