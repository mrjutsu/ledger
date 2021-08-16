<?php

namespace Mrjutsu\Ledger\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Pipeline;

use function Composer\Autoload\includeFile;

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
            if (config('ledger.log_user_creation')) {
                $this->logAction($model, config('ledger.new_user_action'));
            }
        } else {
            $this->logAction($model, self::CREATED_ACTION);
        }
    }

}
