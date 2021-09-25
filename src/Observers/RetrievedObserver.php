<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class RetrievedObserver extends ModelObserver
{
    /**
     * Handle the Model "retrieved" event.
     *
     * @param Model $model
     * @return void
     */
    public function retrieved(Model $model)
    {
        $this->logAction($model, self::RETRIEVED_ACTION);
    }
}