<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm(){
        return view('register.register');
    }

    public function register(Request $request){ 
        $request->validate([
                    // 'mobile_phone' => 'required|string|min:10|max:15|unique:users,phone',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:6',
                    'username' => 'required|string|max:255',
                ]);

        $user = User::create([
            'role_id' => 3,
            'name' => $request->username,
            'email' => $request->email,
            'mobile_phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // // Auto login setelah register
        // auth()->login($user);

        return redirect()->route('login');
    }
}   
