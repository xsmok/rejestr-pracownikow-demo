<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Create an employee account and send the activation link.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            // Letters (any alphabet), spaces and hyphens only.
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // At least 8 characters, including a letter and a digit.
            'password' => ['required', 'confirmed', 'regex:/^(?=.*\pL)(?=.*\d).{8,}$/u'],
        ]);

        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
