<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class CreatingObserver extends ModelObserver
{
    private const CREATING_ACTION = 'Creating';

    /**
     * Handle the Model "creating" event.
     *
     * @param Model $model
     * @return void
     */
    public function creating(Model $model)
    {
        $this->logAction($model, self::CREATING_ACTION);
    }
}