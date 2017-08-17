<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'is_private', 'email'
    ];

    /**
     * Get social provider.
     */
    public function socialProviders(){
        return $this->hasMany('App\SocialProvider');
    }

    /**
     * Get posts from user.
     */
    public function post()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Get user following.
     */
    public function followTo()
    {
        return $this->hasMany('App\Follower');
    }

    /**
     * Get user follower.
     */
    public function follower()
    {
        return $this->hasMany('App\Follower', 'follow_id');
    }

    /**
     * Get all user comments.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get all user likes.
     */
    public function likes()
    {
        return $this->hasMany('App\Likes');
    }
}
