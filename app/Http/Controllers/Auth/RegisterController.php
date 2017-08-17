<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['setUsername', 'saveUsername']);
        $this->middleware('auth')->only(['setUsername', 'saveUsername']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'picture' => 'mimes:jpg,jpeg,png',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|string|min:3|unique:users'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $avatar = NULL;
        if(isset($data['picture']))
        {
            $filename = uniqid();
            $data['picture']->move(public_path('storage/images/avatars'), $filename.'.jpg');
            $avatar = $filename;
        }

        return User::create([
            'name' => $data['name'] . ' ' . $data['surname'],
            'email' => $data['email'],
            'picture' => $avatar,
            'username' => strtolower($data['username']),
            'password' => bcrypt($data['password']),
        ]);
    }

    public function setUsername()
    {
        return view('profile.username');
    }

    public function saveUsername(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:3|max:16|unique:users'
        ]);

        $user = User::find(Auth::id());
        $user->username = $request->username;
        $user->save();

        return redirect()->home();
    }
}
