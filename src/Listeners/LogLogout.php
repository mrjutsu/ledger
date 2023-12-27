<?php

namespace Mrjutsu\Ledger\Listeners;

use Illuminate\Auth\Events\Logout;
use Mrjutsu\Ledger\Ledger;

class LogLogout
{
    public function handle(Logout $event)
    {
        $user = $event->user;

        $user->log(Ledger::LOGOUT_ACTION);
    }
}