<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\User;

class Follower extends Model
{
    protected $fillable = [
        'user_id', 'follow_id', 'accepted',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'follow_id');
    }

    public function post()
    {
        return $this->hasMany('App\Post', 'user_id', 'follow_id');
    }

    /*
    * Check user already followed.
    */
    public function scopeCheck($query, $user_id, $follower_id)
    {
        return $query->where([['user_id', $user_id], ['follow_id', $follower_id]]);
    }

    public function scopeTimeline($query, $user_id)
    {
        $followers = $query->where('user_id', $user_id)->get();
        $me = User::find($user_id)->post;
        foreach ($followers as $follower)
        {
            $me = $me->merge($follower->post);
        }
        return $me->sortByDesc('created_at');
    }
}
