<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class UpdatedObserver extends ModelObserver
{

    private const UPDATED_ACTION = 'Updated';

    /**
     * Handle the Model "updated" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function updated(Model $model)
    {
        $this->logAction($model, self::UPDATED_ACTION);
    }

}
