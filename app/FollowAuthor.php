<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowAuthor extends Model
{
    protected $fillable = [
        'user_id', 'user_follow_id'
    ];
}
