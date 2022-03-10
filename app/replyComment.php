<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class replyComment extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }
}
