<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'schedule_type', 'schedule_id', 'is_seen'
    ];
}
