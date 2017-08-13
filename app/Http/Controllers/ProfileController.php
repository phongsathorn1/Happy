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
        $profile = User::where('username', $username)->first();

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
            'posts' => $profile->post,
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
        $user->surname = $name[1];
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
            'username' => 'required|unique:users',
            'email' => 'required|string|email|max:225|unique:users',
            'password' => 'required'
        ]);

        if(Hash::check($request->password, Auth::user()->password))
        {
            $filename = NULL;

            if($request->hasFile('picture'))
            {
                $filename = uniqid();
                $request->picture->storeAs('public/images/avatars', $filename.'.jpg');
            }

            User::find(Auth::id())->update([
                'name' => $request->name . " " . $request->surname,
                'username' => $request->username,
                'email' => $request->email,
                'picture' => $filename
            ]);
            return redirect('/user/' . Auth::user()->username);
        }
        return back();
    }

    /**
     * Change password
     *
     * @return \Illuminate\Http\Response
     */
    public function password_change()
    {
        return view('profile.password');
    }

    /**
     * Validate incoming request and save password change
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function save_password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'new-password' => 'required|confirmed'
        ]);

        if(Hash::check($request->password, Auth::user()->password))
        {
            User::find(Auth::id())->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect('/user/' . Auth::user()->username);
        }
        return back();
    }
}
