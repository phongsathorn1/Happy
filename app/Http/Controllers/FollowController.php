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

    public function create(Request $request)
    {
        $this->validate($request, [
            'follow_id' => 'required'
        ]);

        if(User::find($request->user_id) != null and $request->user_id != Auth::id())
        {
            $data = [
                'user_id' => Auth::id(),
                'follow_id' => $request->user_id,
                'accepted' => FALSE
            ];

            if(!User::find($request->user_id)->is_private)
            {
                $data['accepted'] = TRUE;
            }

            if(Follower::check(Auth::id(), $request->user_id)->count() <= 0)
            {
                Follower::create($data);
            }
        }
        return back();
    }

    public function delete(Request $request)
    {
        Follower::where([['user_id', Auth::id()], ['follow_id', $request->user_id]])->delete();
        return back();
    }
}
