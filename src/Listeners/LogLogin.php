<?php

namespace Mrjutsu\Ledger\Listeners;

use Illuminate\Auth\Events\Login;
use Mrjutsu\Ledger\Ledger;

class LogLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;

        $user->log(Ledger::LOGGEDIN_ACTION);
    }
}