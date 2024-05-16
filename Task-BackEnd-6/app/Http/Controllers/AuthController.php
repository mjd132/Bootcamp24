<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerPage()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::create($request->all);
        Auth::login($user);
        return redirect('post.index');
    }
    public function loginPage()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('post.index');
        }
        return back()->withErrors(['error' => 'Email or Password not correct!']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('post.index');
    }
}
