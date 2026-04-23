<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticateUser
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user) {
            $pepper = config('app.pepper');
            $passwordWithSaltPepper = $credentials['password']
                . $user->salt . $pepper;
            if (Hash::check($passwordWithSaltPepper, $user->password)) {
                Auth::login($user);
                return $user;
            }
        }
        return null; // Restituisce null se l'autenticazione fallisce
    }
}
