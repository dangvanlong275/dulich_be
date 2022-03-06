<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'description', 'address', '_long', '_lat', 'is_seen'
    ];
}
