<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Follower;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile', [
            'folder' => md5(Auth::id()),
            'posts' => User::find(Auth::id())->post,
            'profile' => Auth::user()
        ]);
    }

    public function timeline()
    {
        return view('timeline', ['posts' => Follower::Timeline(Auth::id())]);
    }
}
