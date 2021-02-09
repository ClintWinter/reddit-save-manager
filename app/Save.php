<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Save extends Model
{
    protected $fillable = ['reddit_id', 'reddit_url', 'thumbnail_url', 'media_url', 'title', 'body'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subreddit()
    {
        return $this->belongsTo(Subreddit::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
