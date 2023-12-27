<?php

namespace Mrjutsu\Ledger\Listeners;

use Illuminate\Auth\Events\Verified;
use Mrjutsu\Ledger\Ledger;

class LogVerified
{
    public function handle(Verified $event)
    {
        $user = $event->user;

        $user->log(Ledger::VERIFIED_ACTION);
    }
}