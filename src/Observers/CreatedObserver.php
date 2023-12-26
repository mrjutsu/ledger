<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Mrjutsu\Ledger\Ledger;

class CreatedObserver extends ModelObserver
{

    /**
     * Handle the Model "created" event.
     *
     * @param Model $model
     * @return void
     */
    public function created(Model $model)
    {
        $user = config('ledger.user');

        if ($model instanceof $user) {
            $this->maybeLogUserRegistration($model);
        } else {
            $this->logAction($model, Ledger::CREATED_ACTION);
        }
    }

}
