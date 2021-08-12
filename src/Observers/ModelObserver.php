<?php

namespace MrJutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

use MrJutsu\Ledger\Models\LedgerLog;

class ModelObserver
{
    protected function logAction(Model $model, string $action)
    {
        $model->loggable()->create([
            'action' => $action,
            'user_id' => auth()->id()
        ]);
    }
}
