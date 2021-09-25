<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    protected const CREATED_ACTION = 'Created';

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
        if (config('ledger.log_user_creation')) {
            $this->logAction($model, auth()->check() ? self::CREATED_ACTION : config('ledger.new_user_action'));
        }
    }
}
