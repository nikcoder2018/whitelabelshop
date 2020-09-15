<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $fillable = ['user_id', 'title', 'slug', 'content', 'thumbnail'];

    function tags(){
        return $this->hasMany(PostTag::class);
    }

    function author(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
