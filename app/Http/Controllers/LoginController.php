<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('login.login');
    }

    public function login(Request $request){
         $validator = Validator::make($request -> all(),[
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            session(['auth_login' => true]);
            $request->session()->regenerate();

            if(Auth::user()->role_id == 2){
                return redirect('dashboard');
            }

            if(Auth::user()->role_id == 1){
                return redirect('dashboard');
            }

            if(Auth::user()->role_id == 3){
                return redirect('dashboard');
            }
           
            
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

}
