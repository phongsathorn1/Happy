<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Socialite;
use App\SocialProvider;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Social authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Social.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try
        {
            $user_social = Socialite::driver($provider)->user();
        }
        catch(\Exception $e)
        {
            return redirect()->home();
        }

        $social_provider = SocialProvider::where('provider_id', $user_social->getId())->first();

        if($social_provider)
        {
            $user = $social_provider->user;
        }
        else
        {
            $user = User::firstOrCreate([
                'name' => $user_social->getName(),
                'email' => $user_social->getEmail(),
                'picture' => null,
                'username' => null,
                'password' => bcrypt(rand()),
            ]);

            $user->socialProviders()->create([
                'provider_id' => $user_social->getId(),
                'provider' => $provider
            ]);
        }

        Auth::login($user);
        return redirect()->home();
    }
}
