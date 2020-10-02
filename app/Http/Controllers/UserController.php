<?php

namespace App\Http\Controllers;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
   public function showregister(){
       return view('auth.register');
   }
   public function showsignin(){
       return view('auth.signin');
   }
   public function signin(Request $request){
    $inputs=request()->validate([

        // 'name'=>['required','string','max:255' ],
        'email'=>['required','email','max:255' ],

        'password'=>['min:6','max:255'  ],


    ]);
    $credentials = [
        'login' => $request['email'],
    ];

    $user = Sentinel::findByCredentials($credentials);
    if(Sentinel::validateCredentials($user, $inputs)){

        Sentinel::loginAndRemember($user);
        return redirect()->route('home');
    }
    else{
    session()->flash('password','Incorrect Password');
      return view('auth.signin');

    }


   }
    public function register(Request $request){
        $inputs=request()->validate([

            // 'name'=>['required','string','max:255' ],
            'email'=>['required','email','max:255' ],

            'password'=>['min:6','max:255','confirmed'  ],


        ]);
        $kod=rand(1,100);


        $user = Sentinel::register($inputs);
        $activation = Activation::create($user);

        $data=[
            'user' => $user,
            'kod'=> $activation->code,
            'email' => $user->email
        ];

        Mail::send('email.emailforma', $data, function ($message) use ($data) {
            $message->from('dusantrivic44@hotmail.com', 'Dusan Trivic');
            $message->sender('dusantrivic44@hotmail.com', 'Dusan Trivic');
            $message->to($data['email'], 'Dusant')->subject('Hello');;

        });

        return  redirect()->route('home');

    }

    public function verificateForm($user_id, $code) {
        $user = Sentinel::findById($user_id);

        if (Activation::complete($user, $code))
        {
             return redirect()->route('home');
        }
        else
        {
            echo 'activation not completed';
        }
    }

    public function verificate($kod, Request $request){

        if($kod == $request['code']){
            $inputs['email']=$request['email'];
            $inputs['password']=$request['password'];
            Sentinel::register($inputs);
            return view('home');
        }


    }
    public function logout(){
        Sentinel::logout(null, true);
        return redirect()->route('show.signin');
    }
    public function userprofile(User $user){

        return view('user.profile',['user'=>$user]);
    }


    public function edit(User $user){




        $inputs=request()->validate([
            'first_name'=>['required','string','max:255'],
            'last_name'=>['required','string','max:255' ],
            'email'=>['required','email','max:255' ],
            'avatar'=>['file' ],
             'password'=>[ 'max:255'],
             'new_password'=>[ 'max:255','required_with:password_confirmation|same:password_confirmation'],
             'password_confirmation'=>[ 'max:255'],


        ]);


            if(Hash::check($inputs['password'], $user->password))
            {
                if($inputs['new_password'])
                {
                    $inputs['password']= $inputs['new_password'];
                    $credentials=[
                        'first_name'=>$inputs['first_name'],
                        'last_name'=>$inputs['last_name'],
                        'password'=>$inputs['password'],
                    ];
                    $user = Sentinel::findById($user['id']);
                    $user = Sentinel::update($user, $credentials);
                   return back();
                }else{
                    $credentials=[
                        'first_name'=>$inputs['first_name'],
                        'last_name'=>$inputs['last_name'],
                    ];
                    $user = Sentinel::findById($user['id']);
                    $user = Sentinel::update($user, $credentials);
                   return back();
                }
            }else
        {
            $credentials=[
                'first_name'=>$inputs['first_name'],
                'last_name'=>$inputs['last_name'],
            ];
            $user = Sentinel::findById($user['id']);
            $user = Sentinel::update($user, $credentials);
           return back();
    }





    //    if(Hash::check($inputs['password'], $user->password))
    //    {
    //        if($inputs['new_password'])
    //        {
    //            $inputs['password']= Hash::make($inputs['new_password']);
    //        }
    //    } else {
    //        $inputs['password']= $user->password;
    //    }
    //    if(request('avatar')){
    //        $inputs['avatar']=request('avatar')->store('images');
    //    }
    //    $user->update($inputs);
    //   return back();
    // }


    }
    public function integrations(){
        return view('user.integrations');
    }
}

