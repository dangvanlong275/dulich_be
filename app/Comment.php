<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'parent_id', 'post_id', 'user_id', 'contents'
    ];
}
