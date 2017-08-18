<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Follower;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('view');
    }

    /**
     * View user profile
     *
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function view($username)
    {
        $profile = User::where('username', $username)->orWhere('id', $username)->first();

        $followed = FALSE;
        if(Auth::check())
        {
            if(Follower::check(Auth::id(), $profile->id)->count() != 0)
            {
                $followed = TRUE;
            }
        }

        return view('profile', [
            'folder' => md5($profile->id),
            'posts' => $profile->post()->orderBy('id', 'desc')->get(),
            'profile' => $profile,
            'followed' => $followed
        ]);
    }

    /**
     * Edit profile
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        $name = explode(" ", $user->name);
        $user->name = $name[0];
        if(isset($name[1]))
        {
            $user->surname = $name[1];
        }
        else
        {
            $user->surname = " ";
        }
        
        return view('profile.edit', ['user' => $user]);
    }

    /**
     * Save edit profile
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function save_edit(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
            'username' => 'required|alpha_num|min:3|max:16',
            'email' => 'required|string|email|max:225'
        ]);

        $filename = NULL;

        if($request->hasFile('picture'))
        {
            $filename = uniqid();
            $request->file('picture')->move(public_path('storage/images/avatars'), $filename.'.jpg');
        }

        User::find(Auth::id())->update([
            'name' => $request->name . " " . $request->surname,
            'username' => strtolower($request->username),
            'email' => $request->email,
            'picture' => $filename
        ]);

        return redirect('/user/' . (is_null(Auth::user()->username) ? Auth::user()->id : $request->username));
    }

    /**
     * View follower
     *
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function follower($username)
    {
        $followers = User::where('username', $username)->orWhere('id', $username)->first()->follower()->get();
        return view('profile.follower', [
            'title' => 'Follower',
            'followers' => $followers
        ]);
    }

    /**
     * View following
     *
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function following($username)
    {
        $followers = User::where('username', $username)->orWhere('id', $username)->first()->followTo()->get();
        return view('profile.follower', [
            'title' => 'Following',
            'followers' => $followers
        ]);
    }
}
