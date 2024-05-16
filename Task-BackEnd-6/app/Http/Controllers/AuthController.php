<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerPage()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $user = User::create($validator->getData());


        // return back()->with(['error' => 'A user with this email has already registered!']);
        // return back()->with(['message' => $user->wasRecentlyCreated]);
        Auth::login($user);
        return to_route('post.index');
    }
    public function loginPage()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (Auth::attempt($validatedData))
            return redirect()->route('post.index');

        return back()->with(['error' => 'Email or Password not correct!']);
    }

    public function logout()
    {
        Auth::logout();
        return to_route('post.index');
    }
}
