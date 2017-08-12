<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'photo', 'people_count', 'description',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function likes()
    {
        return $this->hasMany('App\Likes');
    }

    public function scopeDiscover($query)
    {
        $posts = $query->inRandomOrder()->get()->filter(function($value, $key){
            return $value->user->is_private == 0;
        });

        return $posts;
    }
}
