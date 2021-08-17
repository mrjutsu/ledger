<?php

namespace Mrjutsu\Ledger\Models;

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
        'details',
        'user_id',
        'loggable_id',
        'loggable_type',
    ];


    public function loggable()
    {
        return $this->morphTo();
    }
    
    public function getDetailsAttribute($value)
    {
        return json_decode($value, true) ?? $value;
    }
}
