<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class DiscoverController extends Controller
{
    public function index()
    {
        $posts = Post::Discover();
        return view('discover', ['posts' => $posts]);
    }
}
