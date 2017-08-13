<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Post;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show upload page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload');
    }

    /**
     * Show uploaded image and prepare for post.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        $this->validate($request, [
            'picture' => 'mimes:jpg,jpeg,png'
        ]);

        $filename = uniqid();
        if(!$request->hasFile('picture'))
        {
            $data = explode(',', $request->base_picture);
            $img = base64_decode($data[1]);
            Storage::disk('public')->put('images/' . md5(Auth::id()) . '/' . $filename . '.jpg', $img);
        }
        else
        {
            $request->picture->storeAs('public/images/' . md5(Auth::id()), $filename.'.jpg');
        }
        return view('create', ['folder' => md5(Auth::id()), 'photo' => $filename]);
    }

    /**
     * Validate incoming request and post it.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required',
            'description' => 'required'
        ]);

        $description = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $request->description);
        Post::create([
            'user_id' => Auth::id(),
            'photo' => $request->photo,
            'people_count' => 1,
            'description' => $description,
        ]);

        return redirect('/user/' . Auth::user()->username);
    }
}
