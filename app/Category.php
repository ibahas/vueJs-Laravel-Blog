<?php

namespace App;
use App\Post;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function post()
{
    return $this->belongsToMany(Post::class, 'category_id');
}
}
