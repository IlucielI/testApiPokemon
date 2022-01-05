<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function signin()
    {
        return view('signin', ['title' => 'Sign In']);
    }
    public function signup()
    {
        return view('signup', ['title' => 'Sign Up']);
    }

    public function signupStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:users|min:3',
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => 'required|min:5',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect('/signin')->with('message', 'Your Sign up Success.');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/mypokemon');
        }

        return back()->with('messageError', 'Your Sign in Failed.');
    }

    public function signout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/signin')->with('message', 'Your Sign out Success.');;
    }
}
