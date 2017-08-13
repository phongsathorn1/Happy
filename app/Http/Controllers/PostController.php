<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Likes;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('view');
    }

    /**
     * View the post by post_id.
     *
     * @param int $post_id
     * @return \Illuminate\Http\Response
     */
    public function view($post_id)
    {
        $post = Post::find($post_id);
        return view('post', ['folder' => md5($post->user->id), 'post' => $post]);
    }

    /**
     * Like function.
     *
     * @param int $post_id
     * @return \Illuminate\Http\Response
     */
    public function like($post_id)
    {
        if(Likes::where([['user_id', Auth::id()], ['post_id', $post_id]])->count() == 0)
        {
            Likes::create([
                'post_id' => $post_id,
                'user_id' => Auth::id()
            ]);
        }

        return back();
    }

    /**
     * Unlike function.
     *
     * @param int $post_id
     * @return \Illuminate\Http\Response
     */
    public function unlike($post_id)
    {
        $like = Likes::where([['user_id', Auth::id()], ['post_id', $post_id]]);
        if($like->count() != 0)
        {
            $like->delete();
        }

        return back();
    }

    /**
     * Delete the post.
     *
     * @param int $post_id
     * @return \Illuminate\Http\Response
     */
    public function delete($post_id)
    {
        $post = Post::find($post_id);
        if($post->user_id == Auth::id())
        {
            $post->delete();
            return redirect('/user/' . Auth::user()->username);
        }

        return abort(403, "You don't have permission");
    }

    /**
     * Edit the post.
     *
     * @param int $post_id
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $post = Post::find($post_id);
        if($post->user->id == Auth::id())
        {
            return view('post.edit', ['post' => $post, 'folder' => md5($post->user->id)]);
        }

        return abort(403, "You don't have permission");
    }

    /**
     * Save change from edit page.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $post_id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $post_id)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);

        $post = Post::find($post_id);
        if($post->user_id == Auth::id())
        {
            $description = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $request->description);
            $post->update(['description' => $description]);

            return redirect('/posts/' . $post_id);
        }

        return abort(403, "You don't have permission");
    }
}
