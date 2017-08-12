<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'content' => $request->comment,
        ]);

        return back();
    }
}
