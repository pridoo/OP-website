<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image'];

    //fetch comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    //fetch likes
    public function likes()
{
    return $this->hasMany(Like::class);
}
}
