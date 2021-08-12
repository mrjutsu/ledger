<?php

namespace MrJutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class DeletedObserver extends ModelObserver
{

    public const DELETED_ACTION = 'Deleted';

    /**
     * Handle the Model "deleted" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->logAction($model, self::DELETED_ACTION);
    }

}
