<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show register form
    public function create(){
        return view('users.register');
    }

    //create new user

    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', ' min:3'],
            'email' => ['required','email', Rule::unique('users','email')],
            'password' => 'required|confirmed|min:6'
        ]);

        //Hash password
        $formFields['password'] = bcrypt($formFields['password']);
        
        //create user
        $user = User::create($formFields);

        // user login
        auth()->login($user);

        return redirect('/')->with('message','New Registered and Logged in');
    }

    //logout

    public function logout(Request $request){
        //remove the auth info from the user session
        auth()->logout();

        //invalidate the user session and regen the csrf token
         $request->session()->invalidate();
         $request->session()->regenerateToken();

         return redirect('/')->with('message','You Have Been Logged Out');
    }

    //show login form

    public function login(){
        return view('users.login');
    }

    public function authenticate(Request $request){

        $formFields = $request->validate([
            'email'=>['required', 'email'],
            'password' => 'required'
        ]);
        if(auth()->attempt($formFields)){
        $request->session()->regenerate();

        return redirect('/')->with('message', 'You are now logged in');
        }
        return back()->withErrors(['email'=>'invalid credentials'])->onlyInput('email');
    }
}

