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
            $request->file('picture')->move(public_path('storage/images/' . md5(Auth::id())), $filename.'.jpg');
        }

        /**
         * Call to Emotion API and get result.
         */
        $image_url = url('storage/images/' . md5(Auth::id()) .'/' . $filename . '.jpg');
        $subscribe_key = env('EMOTION_API_KEY');

        $headers = [
            'Content-Type: application/json',
            'Ocp-Apim-Subscription-Key: '.$subscribe_key
        ];
        $data_string = ['url' => $image_url];
        $data_string = json_encode($data_string);
        $ch = curl_init('https://westus.api.cognitive.microsoft.com/emotion/v1.0/recognize');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);

        $results = [];
        $emotion_results = json_decode($data, true);
        foreach($emotion_results as $value){
            $result = array_keys($value["scores"], max($value["scores"]));
            array_push($results, $result[0]);
        }

        $emotion_pass = true;
        foreach($results as $result)
        {
            if($result != "happiness" && $result != "surprise"){
                $emotion_pass = false;
            }
        }

        $photo_emotion = array_count_values($results);
        $people_count = count($emotion_results);

        //pass data to view
        return view('create', [
            'folder' => md5(Auth::id()),
            'photo' => $filename,
            'emotion_pass' => $emotion_pass,
            'photo_emotion' => $photo_emotion,
            'people_count' => $people_count
        ]);
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
