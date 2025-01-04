<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use PragmaRX\Google2FALaravel\Google2FA;
use Illuminate\Http\RedirectResponse;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Google2FA $google2fa): RedirectResponse
    {
        // Validate the registration data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Set the role as 'customer'
        ]);

        // Generate the 2FA secret key
        $secret = $google2fa->generateSecretKey();

        // Store the secret in the user's record
        $user->google2fa_secret = $secret;
        $user->save();

        // Log in the user immediately after registration
        Auth::login($user);

        // Redirect to the 2FA setup page with QR code details
        return redirect()->route('2fa.show')->with([ 
            'qrCodeUrl' => $google2fa->getQRCodeUrl(
                config('app.name'),
                $user->email,
                $secret
            ),
            'secret' => $secret,
        ]);               
    }
}
