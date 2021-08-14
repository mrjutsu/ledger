<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class CreatedObserver extends ModelObserver
{

    private const CREATED_ACTION = 'Created';

    /**
     * Handle the Model "created" event.
     *
     * @param Model $model
     * @return void
     */
    public function created(Model $model)
    {
        $this->logAction($model, self::CREATED_ACTION);
    }

}
