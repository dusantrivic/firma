<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;


use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {

        $userSocialite = Socialite::driver('facebook')->stateless()->user();
         $credentials=[
            'login'=>$userSocialite->email,
         ];

         if($user = Sentinel::findByCredentials($credentials)){
         $user = Sentinel::findById($user->id);


       if(    $activation = Activation::completed($user)){

        Sentinel::login($user);
        return redirect()->route('home');
       }
       else
       {
       $user->delete();
        $credentials1 = [
            'email'    => $userSocialite->email,
            'password' => '12345678',
        ];
        $user = Sentinel::registerAndActivate($credentials1);
        return redirect()->route('home');
       }
         }
         else{
            $credentials1 = [
                'email'    => $userSocialite->email,
                'password' => '12345678',
                'first_name'=>$userSocialite->getName(),
            ];

            $user = Sentinel::registerAndActivate($credentials1);
            return redirect()->route('home');
         }
        // $user->token;
    }
}
