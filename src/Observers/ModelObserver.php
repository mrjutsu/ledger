<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    protected function logAction(Model $model, string $action)
    {
        $model->ledgerLogs()->create([
            'action' => $action,
            'user_id' => auth()->id()
        ]);
    }
}
