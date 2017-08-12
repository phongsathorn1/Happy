<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class TimelineController extends Controller
{
    public function index()
    {
        $followers = Auth::user()->follower->get();
        $posts = collect();
        foreach ($followers as $follower)
        {
            $posts = $posts->merge($follower)
        }
    }
}
