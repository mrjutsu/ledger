<?php

namespace Mrjutsu\Ledger;

use Illuminate\Database\Eloquent\Model;

class Ledger
{
    /*
     * Returns the User class specified in Ledger's config
     * */
    public static function user()
    {
        return config('ledger.user');
    }

    /*
     * Returns whether the passed parameter is an instance of the specified User class or not
     * */
    public static function isUserClass(Model $model)
    {
        $user = config('ledger.user');
        
        return $model instanceof $user;
    }

}