<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;

class SavedObserver extends ModelObserver
{
    private const SAVED_ACTION = 'Saved';

    /**
     * Handle the Model "saved" event.
     *
     * @param Model $model
     * @return void
     */
    public function saved(Model $model)
    {
        $loggedFields = $model->getLoggedFields();
        $details = null;

        if (!empty($loggedFields)) {
            $changes = [
                'fields' => []
            ];
            foreach ($model->getChanges() as $field => $value) {
                if (in_array($field, $loggedFields) && $model->isDirty($field)) {
                    $changes['fields'][$field] = [
                        'old' => $model->getOriginal($field),
                        'new' => $value
                    ];
                }
            }
            $details = json_encode($changes);
        }

        $this->logAction($model, self::SAVED_ACTION, $details);
    }
}