<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use GuzzleHttp\Client;

class SocialAuthController extends Controller
{
    // Google Login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')
        ->setHttpClient(new Client(['verify' => false])) // Disable SSL verification
        ->stateless()
        ->user();

    $this->registerOrLoginUser($user);
    return redirect()->route('home');
    }

    // Facebook Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {

        $user = Socialite::driver('facebook')
            ->setHttpClient(new Client(['verify' => false])) // Disable SSL verification
            ->stateless()
            ->user();
        
        $this->registerOrLoginUser($user);
        return redirect()->route('home');
        
    }

    // Register or Login User
    protected function registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => bcrypt('defaultpassword'), // or null if not needed
            ]);
        }

        Auth::login($user);
    }
}
 ?>