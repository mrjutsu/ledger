<?php

namespace Mrjutsu\Ledger\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Mrjutsu\Ledger\Ledger;

class LogPasswordReset
{
    public function handle(PasswordReset $event)
    {
        $user = $event->user;

        $user->log(Ledger::PASSWORD_RESET_ACTION);
    }
}