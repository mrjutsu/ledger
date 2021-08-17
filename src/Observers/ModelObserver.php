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
}
