<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Google2FA;

class TwoFactorController extends Controller
{
    // Show the 2FA setup page with QR code and secret key
    public function show(Google2FA $google2fa)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Generate a secret key for the user
        $secret = $google2fa->generateSecretKey();

        // Generate the QR code URL
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'), // Application Name
            $user->email,       // User's email
            $secret             // Secret key
        );

        // Pass the QR code URL and secret to the view
        return view('auth.2fa', [
            'qrCodeUrl' => $qrCodeUrl,
            'secret' => $secret,
        ]);
    }
}
