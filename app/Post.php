<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'photo', 'people_count', 'description',
    ];

    /**
     * Get owner of post.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get post comments.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the post likes.
     */
    public function likes()
    {
        return $this->hasMany('App\Likes');
    }

    /**
     * Get discover posts.
     *
     * @param Illuminate\Database\Eloquent $query
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function scopeDiscover($query)
    {
        $posts = $query->inRandomOrder()->get();

        return $posts;
    }
}
