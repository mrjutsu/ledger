<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    protected function logAction(Model $model, string $action, string $details = null)
    {
        $model->ledgerLogs()->create([
            'action' => $action,
            'details' => $details,
            'user_id' => auth()->id()
        ]);
    }
    
    protected function parseDetails(Model $model)
    {
        return json_encode($model->toArray());
    }

    protected function maybeLogUserRegistration(Model $model)
    {
        if (config('ledger.log_user_creation') && !auth()->check()) {
            $this->logAction($model, config('ledger.new_user_action'));
        }
    }
}
