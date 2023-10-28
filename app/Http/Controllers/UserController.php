<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show register/create form
    public function create() {
        return view('users.register');
    }

    //Store - Create a new user
    public function store(Request $request) {
        $formField = $request->validate([
            'name'=>'required',
            'email'=>['required', 'email', Rule::unique('users', 'email')],
            'password'=>'required|confirmed|min:6'
        ]);
        
        //Hash Password
        $formField['password'] = bcrypt($formField['password']);

        //Create User
        $user = User::create($formField);

        //User login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and Logged in!');


    }
    
    //logout user
    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have logged out!!!');
    }
    

    //Show login form
    public function login() {

        return view('users.login');


    }

    //Authenticate and login user
    public function authenticate(Request $request) {
        $formField = $request->validate([
            'email'=>['required', 'email'],
            'password'=>'required'
        ]);

        if(auth()->attempt($formField)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You are now logged-in!');
        }

        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');



    }
}
