<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class DeletedObserver extends ModelObserver
{

    private const DELETED_ACTION = 'Deleted';

    /**
     * Handle the Model "deleted" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $details = $this->parseDetails($model);
        
        $this->logAction($model, self::DELETED_ACTION, $details);
    }

}
