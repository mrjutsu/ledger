<?php

namespace MrJutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserver extends ModelObserver
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
