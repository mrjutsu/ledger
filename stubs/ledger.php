<?php

return [
    /*
     * User Class
     *
     * Here you can specify your project's User class.
     *
     * */
    'user' => \App\Models\User::class,

    /*
     * User Primary Key
     *
     * If your User class has a primary key other than id, you can specify it here.
     *
     * */
    'user_primary_key' => 'id',
    
    /*
     * Log User Creation
     * 
     * There are cases where a new User creation won't have another User as a responsible, like
     * when someone registers for your application. This option allows you to specify if you
     * wish to log when that happens.
     * 
     * */
    'log_user_creation' => true,
    
    /*
     * New User Action
     * 
     * When a User registers, Ledger will set the action as the value specified here.
     * 
     * */
    'new_user_action' => \Mrjutsu\Ledger\Observers\ModelObserver::REGISTERED_ACTION,
    
    /*
     * Deleting Force Delete Prior Deleted Action
     * 
     * When force deleting a model, a Deleted event will be logged prior to the actual Force Deleted one, this option
     * allows you to specify if you wish that prior action to be removed in order to prevent confusion by having
     * duplicated Deleted actions. This will be done only if there is one prior action logged. For example, if
     * you previously soft deleted a model and then restored it, that Deleted action will be kept, but the
     * Deleted action logged immediately before the Force Deleted one will be removed.
     * 
     * */
    'delete_force_delete_prior_action' => true,
];