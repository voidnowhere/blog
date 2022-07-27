<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);

        if (!auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'auth' => 'Provided email or password is invalid.',
            ]);
        }

        session()->regenerate();

        return redirect('/')->with('success', 'Welcome Back!');
    }

    public function destroy()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/')->with('success', 'Goodbye!');
    }
}
