<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class ForceDeletedObserver extends ModelObserver
{
    /**
     * Handle the Model "forceDeleted" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        $details = $this->parseDetails($model);

        if (config('ledger.delete_force_delete_prior_action')) {
            $this->deleteForceDeletePriorAction($model);
        }

        $this->logAction($model, self::FORCE_DELETED_ACTION, $details);
    }

}
