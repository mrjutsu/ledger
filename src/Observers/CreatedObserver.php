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
        $user = config('ledger.user');

        if ($model instanceof $user) {
            $this->maybeLogUserRegistration($model);
        } else {
            $this->logAction($model, self::CREATED_ACTION);
        }
    }

}
