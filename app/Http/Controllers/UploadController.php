<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
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
            Image::make(base64_decode($data[1]))->resize(720, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/' . md5(Auth::id()) . '/' . $filename.'.jpg'));

        }
        else
        {
            Image::make($request->file('picture'))->resize(720, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('storage/images/' . md5(Auth::id()) . '/' . $filename.'.jpg'));
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
        $emotion_pass = true;
        $emotion_results = json_decode($data, true);
        $people_count = count($emotion_results);
        list($img_width, $img_height, $img_type, $img_attr) = getimagesize($image_url);
        $face_ractangles = [];

        if($people_count > 0){
            if(isset($emotion_results['error'])){
                return $emotion_results['error']['message'];
            }
            foreach($emotion_results as $value){
                $result = array_keys($value["scores"], max($value["scores"]));
                array_push($results, $result[0]);

                //require image height
                array_push($face_ractangles, [
                    'top' => $value['faceRectangle']['top'] / $img_height * 100,
                    'left' => $value['faceRectangle']['left']  / $img_width  * 100,
                    'width' => $value['faceRectangle']['width'] / $img_width  * 100,
                    'height' => $value['faceRectangle']['height'] / $img_height * 100,
                    'emotion' => $result[0]
                ]);
            }

            $emotion_pass = true;
            foreach($results as $result)
            {
                if($result != "happiness" && $result != "surprise"){
                    $emotion_pass = false;
                }
            }
        }else{
            $emotion_pass = false;
        }

        $photo_emotion = array_count_values($results);

        //pass data to view
        return view('create', [
            'folder' => md5(Auth::id()),
            'photo' => $filename,
            'emotion_pass' => $emotion_pass,
            'photo_emotion' => $photo_emotion,
            'people_count' => $people_count,
            'face_rectangles' => $face_ractangles
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
            'people_count' => 'required|integer',
        ]);

        $description = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $request->description);
        Post::create([
            'user_id' => Auth::id(),
            'photo' => $request->photo,
            'people_count' => $request->people_count,
            'description' => $description,
        ]);

        if(is_null(Auth::user()->username))
        {
            return redirect('/user/' . Auth::user()->id);
        }
        else
        {
            return redirect('/user/' . Auth::user()->username);
        }
    }
}
