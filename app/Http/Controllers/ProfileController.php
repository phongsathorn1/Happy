<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Follower;

class ProfileController extends Controller
{
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

    public function edit()
    {
        $user = Auth::user();
        $name = explode(" ", $user->name);
        $user->name = $name[0];
        $user->surname = $name[1];
        return view('profile.edit', ['user' => $user]);
    }

    public function save_edit(Request $request){
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

    public function password_change()
    {
        return view('profile.password');
    }

    public function save_password(Request $request)
    {
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
