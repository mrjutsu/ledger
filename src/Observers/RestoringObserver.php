<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

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
        $this->logAction($model, self::RESTORING_ACTION);
    }
}