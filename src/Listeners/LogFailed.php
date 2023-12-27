<?php

namespace Mrjutsu\Ledger\Listeners;

use Illuminate\Auth\Events\Failed;
use Mrjutsu\Ledger\Ledger;

class LogFailed
{
    public function handle(Failed $event)
    {
        $user = $event->user;

        $user->log(Ledger::FAILED_ACTION);
    }
}