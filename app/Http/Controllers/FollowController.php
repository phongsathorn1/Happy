<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Follower;
use App\User;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Validate incoming request and create user follow
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required'
        ]);

        if(User::find($request->user_id) != null && $request->user_id != Auth::id())
        {
            $data = [
                'user_id' => Auth::id(),
                'follow_id' => $request->user_id,
                'accepted' => false
            ];

            if(!User::find($request->user_id)->is_private)
            {
                $data['accepted'] = true;
            }

            if(Follower::check(Auth::id(), $request->user_id)->count() <= 0)
            {
                Follower::create($data);
            }
        }
        return back();
    }

    /**
     * Unfollow user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required'
        ]);

        Follower::where([['user_id', Auth::id()], ['follow_id', $request->user_id]])->delete();
        return back();
    }
}
