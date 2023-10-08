<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserService
{
    /**
     * Regster user
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): Response
    {
        // Reqest validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            // The Password::defaults() method retrieves these default rules (config/auth.php) and applies them to the password field.
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create and store new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
