<?php

namespace MrJutsu\Ledger\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'user_id',
        'loggable_id',
        'loggable_type',
    ];
}
