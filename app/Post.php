<?php

namespace App;

use App\Category;
use App\User;
use App\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }
    public function replies()
    {
        return $this->hasMany(replyComment::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_id');
    }
}
