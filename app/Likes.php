<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'user_id',
    ];

    /**
     * Get user that like the post.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get post from like.
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
