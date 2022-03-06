<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaveLikePost extends Model
{
    protected $fillable = [
        'user_id', 'post_id', 'type'
    ];
}
