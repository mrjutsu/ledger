<?php

namespace Mrjutsu\Ledger\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Mrjutsu\Ledger\Ledger;

class LogAuthenticated
{
    public function handle(Authenticated $event)
    {
        $user = $event->user;

        $user->log(Ledger::AUTHENTICATED_ACTION);
    }
}